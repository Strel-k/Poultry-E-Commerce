    <?php
    include "script/database.php";
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    session_start();

    include "script/logged-in.php";
    include "script/show-options.php";
    $is_admin = false; 
    $product_id = null;
    $userID = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
    if (isset($_SESSION['user_id'])) {
        $query = "SELECT role FROM accounts WHERE id = '$userID'";
        $result = mysqli_query($connection, $query);
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $userRole = $row['role'];
            if ($userRole == 1) {
                $is_admin = true;
            }
        }
    }


    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['comment'])) {
        if (!isset($_SESSION['user_id'])) {
            echo "<script>window.location.href = 'product.php?id=$product_id';</script>";
            exit();
        }
    
        $comment = mysqli_real_escape_string($connection, $_POST['comment']);
        $rating = mysqli_real_escape_string($connection, $_POST['rating']); // Capture rating
        if (!empty($comment) && !empty($rating)) { 
            if (isset($_GET['id'])) {
                $product_id = mysqli_real_escape_string($connection, $_GET['id']);
            }
            $insertCommentSql = "INSERT INTO comments (product_id, customer_id, comment, rating, date) 
            VALUES ('$product_id', '$userID', '$comment', '$rating', NOW())"; 
    
            if (mysqli_query($connection, $insertCommentSql)) {
                header("Location: {$_SERVER['PHP_SELF']}?id=$product_id");
                exit();
            } else {
                echo "Error: " . mysqli_error($connection);
            }
        } else {
            if (isset($_GET['id'])) {
                $product_id = mysqli_real_escape_string($connection, $_GET['id']);
            }
            header("Location: {$_SERVER['PHP_SELF']}?id=$product_id");
            exit();
        }
    }

    if (isset($_GET['id'])) {
        $product_id = mysqli_real_escape_string($connection, $_GET['id']);
        $sql = "SELECT * FROM products WHERE id = '$product_id'";
        $result = mysqli_query($connection, $sql);
        if ($result && mysqli_num_rows($result) > 0) {
            $product = mysqli_fetch_assoc($result);

            $sql_comments = "SELECT comments.*, COUNT(comment_likes.id) AS total_likes 
                            FROM comments 
                            LEFT JOIN comment_likes ON comments.id = comment_likes.comment_id
                            WHERE product_id = '$product_id'
                            GROUP BY comments.id";
            $result_comments = mysqli_query($connection, $sql_comments);
        } else {
            header("Location:product.php?id=$product_id");
            exit();
        }
    } else {
        header("Location: homepage.php");
        exit();
    }

    $sql_suggestions = "SELECT * FROM products ORDER BY RAND() LIMIT 3";
    $result_suggestions = mysqli_query($connection, $sql_suggestions);

    ?>

                <!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

                    <link rel="stylesheet" type="text/css" href="css/product.css">
                    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

                    <title>Product | Prototype</title>
                </head>
                <style>
                    * {
                        text-decoration: none !important;
                    }
                    
                </style>
                <body>
                    <div class="header">
                        <div class="logo-container">
                        <a href="homepage.php">  <h1 style="color:orange;">NUTRIPAWS</h1>
                            <h3>Poultry Farm Solutions</h3></a> 
                        </div>
                        <a href="admin-deliveries.php"> <div class="a-container">
       <h3>Delivery</h3>
    </div></a>  
                        <a href="checkout.php"> <div class="a-container">
                            <h3>Checkout</h3>
                        </div></a>
                        <?php if(isset($_SESSION['user_id'])): ?>
                    <a href="script/logout.php"><div class="a-container">
                        <h3>Logout</h3>
                    </div></a>
                    <div class="user-info">
                        <p><?php echo $fullName; ?></p>
                        <img src="<?php echo $profilePicture; ?>" alt="Profile Picture" height="60" width="55">
                    </div>
                <?php else: ?>
                    <a href="register.php"><div class="a-container">
                        <h3>Registration</h3>
                    </div></a>
                    <a href="login.php"><div class="a-container">
                    <h3>Login</h3>
                    </div></a>
                <?php endif; ?>

                    </div>

                    <div class="header" style="background-color: orange; ">
                        <a href="homepage.php">  <div class="a-container">
                        <h4>Home</h4>
                        </div></a>
                        <div class="separator"></div> 
                        <a href="about-us.php"> <div class="a-container">
                        <h4>About</h4>
                        </div></a>
                        <div class="separator"></div>
                        <div class="a-container">
                            <a href="#"><h4>Portfolio</h4></a>
                        </div>
                        <div class="separator"></div>
                        <a href="store.php">  <div class="a-container">
                            <h4>Store</h4>
                        </div></a>
                        <div class="separator"></div>
                        <div class="a-container">
                            <a href="#"><h4>Blog</h4></a>
                        </div>
                        <div class="separator"></div>
                        <div class="a-container">
                            <a href="#"><h4>Contact</h4></a>
                        </div>
                    </div>
                    <div class="content" style="background-color: orange; padding:30px;">
                    <div class="product">
                        <?php if ($product != null): ?>
                        <div class="product-text">
                            <h1><?php echo $product['name']; ?></h1><br>
                            <h7>Product Description:</h7><br>
                            <p><?php echo $product['description']; ?></p><br>
                        </div>      <div class="image-container">
                        <img src="<?php echo $product['image_url']; ?>" alt="<?php echo $product['name']; ?>" width="500" height="550">

                        </div>
                        <div class="product-price">
                            <h3><?php echo $product['price']; ?></h3>
                        
                            <form method="POST" action="script/add-to-cart.php">
                <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                <input type="hidden" name="account_id" value="<?php echo $userID; ?>"> 
                <input type="hidden" id="total_price" name="total_price" value="<?php echo $product['price']; ?>">
                <div class="quantity-control">
                <button type="button" class="quantity-btn" onclick="decrementQuantity()">-</button>
                <input type="number" name="total_quantity" id="total_quantity" min="1" value="1" style="text-align: center;">
                <button type="button" class="quantity-btn" onclick="incrementQuantity()">+</button>
                </div>
                <br><br>
                <button type="submit" class="add-btn">Add to Cart</button>
                </form>




                        </div>
                        <label for="rating">Rating:</label>
        <select id="rating" name="rating">
            <option value="1">1 Star</option>
            <option value="2">2 Stars</option>
            <option value="3">3 Stars</option>
            <option value="4">4 Stars</option>
            <option value="5">5 Stars</option>
        </select><br><br>
        <button id="submit-rating-btn" class="buy-btn">Submit Rating</button>
        <p>Average Rating: <?php echo $product['rating']; ?></p>
                        <br>
                        
                        <?php else: ?>
                        <p>No product found.</p>
                        <?php endif; ?>
                    </div>
                </div>
                    <br>
                    <div class="comments">
                <h1>Comments</h1>
                <hr>

                <div class="new-comment">
                <form method="POST" action="product.php?id=<?php echo $product_id; ?>">
                        <label for="comment">Add a comment:</label>
                        <textarea id="comment" name="comment" rows="4" cols="50" required></textarea><br>
                        <button type="submit" style="box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.5); border-radius:15px;">Submit</button>
                        <label for="rating">Rating:</label>
                            <select id="rating" name="rating">
                             <option value="1">1 Star</option>
                             <option value="2">2 Stars</option>
                              <option value="3">3 Stars</option>
                             <option value="4">4 Stars</option>
                             <option value="5">5 Stars</option>
                            </select>
                    </form>
                </div>
                <hr style="width:100%; margin-left:1%; margin-top:1%;">
                <br>

                <div class="existing-comments">
                <?php if ($result_comments && mysqli_num_rows($result_comments) > 0) : ?>
                    <?php while ($comment = mysqli_fetch_assoc($result_comments)) : ?>
                        <div class="comment">
                            <div class="avatar">
                                <?php
                                $customer_id = $comment['customer_id'];
                                $profile_picture_sql = "SELECT profile_picture FROM accounts WHERE id = '$customer_id'";
                                $profile_picture_result = mysqli_query($connection, $profile_picture_sql);
                                $profile_picture_row = mysqli_fetch_assoc($profile_picture_result);
                                $profile_picture = $profile_picture_row['profile_picture'];
                                ?>
                                <img src="<?php echo $profile_picture; ?>" alt="User Avatar">
                            </div>
                            <div class="comment-details">
                                <div class="author">
                                    <?php
                                    $user_sql = "SELECT username FROM accounts WHERE id = '$customer_id'";
                                    $user_result = mysqli_query($connection, $user_sql);
                                    $author_name = "Guest"; 
                                    if ($user_result && mysqli_num_rows($user_result) > 0) {
                                        $user_row = mysqli_fetch_assoc($user_result);
                                        $author_name = $user_row['username'];
                                    }
                                    ?>
                                    <span><?php echo $author_name; ?></span>
                                    <span><?php echo $comment['date']; ?></span>
                                </div>
                                <p><?php echo $comment['comment']; ?></p>  
                                <div class="rating">
                        <?php
                        $rating = $comment['rating'];
                        for ($i = 1; $i <= $rating; $i++) {
                            echo '<i class="fas fa-star"></i>';
                        }
                        for ($i = $rating + 1; $i <= 5; $i++) {
                            echo '<i class="far fa-star"></i>';
                        }
                        ?>
                    </div>     
                                <div class="actions">
    <?php
    if ($is_admin || $comment['customer_id'] == $userID) :
    ?>
        <?php if ($is_admin|| $comment['customer_id'] == $userID) : ?>
            <form method="POST" action="script/delete-comment.php">
                <input type="hidden" name="comment_id" value="<?php echo $comment['id']; ?>">
                <button type="submit" class="delete-btn" style="background-color:red; margin-bottom:-20%; margin-right:65%;">Delete</button>
            </form>
        <?php endif; ?>
        <?php if ($comment['customer_id'] == $userID) : ?> 
            <button class="edit-btn delete-btn" onclick="toggleEditForm(<?php echo $comment['id']; ?>)" style="background-color:green; padding:10px; width:10%; border-radius:5px;">Edit</button>

            <form id="editForm<?php echo $comment['id']; ?>" method="POST" action="script/edit-comment.php" style="display: none;">
                <input type="hidden" name="comment_id" value="<?php echo $comment['id']; ?>">
                <br>
                <textarea name="edited_comment" rows="3" cols="30" style="margin-top: 10px; margin-bottom: 10px;"><?php echo $comment['comment']; ?></textarea>
                <button type="submit" class="edit-btn delete-btn" style="background-color:green;">Save</button>
                <br>
                <label for="edited_rating<?php echo $comment['id']; ?>">Rating:</label>
                <select id="edited_rating<?php echo $comment['id']; ?>" name="edited_rating">
                    <?php for ($i = 1; $i <= 5; $i++) : ?>
                        <option value="<?php echo $i; ?>" <?php if ($comment['rating'] == $i) echo 'selected'; ?>><?php echo $i; ?> Star<?php echo ($i > 1) ? 's' : ''; ?></option>
                    <?php endfor; ?>
                </select>
            </form>
        <?php endif; ?>
    <?php endif; ?>
    <hr style="width:105%; margin-left:-5%; margin-top:1%;">
</div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else : ?>
                    <p style="text-align:center;">No comments yet.</p>
                <?php endif; ?>
                </div>
                    </div>
                    
                </div>
                <div class="content-suggestions" style="background-color:orange;">
                <div class="best-sellers">
                    <br>
                    <h1 style="color:black;">Suggestions</h1><br>
                    <hr>
                    <?php
                    if (mysqli_num_rows($result_suggestions) > 0) {
                        while ($row_suggestion = mysqli_fetch_assoc($result_suggestions)) {
                            ?>
                            <div class="product-container">
                                <a href="product.php?id=<?php echo $row_suggestion['id']; ?>">
                                    <img src="<?php echo $row_suggestion['image_url']; ?>" width="100" height="100" alt="<?php echo $row_suggestion['name']; ?>">
                                </a>
                                <h5><?php echo $row_suggestion['name']; ?></h5>
                                <p>Rating: <?php echo $row_suggestion['rating']; ?></p>
                                <?php
                                $rating = $row_suggestion['rating'];
                                for ($i = 1; $i <= $rating; $i++) {
                                    echo '<i class="fas fa-star"></i>';
                                }

                                for ($i = $rating + 1; $i <= 5; $i++) { 
                                    echo '<i class="far fa-star"></i>';
                                }
                                ?>
                            </div>
                            <?php
                        }
                    } else {
                        echo "<p>No suggestions found.</p>";
                    }
                    ?>
                </div>
                    <br>
                    <script>
          document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("submit-rating-btn").addEventListener("click", function() {
        console.log("Submit rating button clicked."); 
        var rating = document.getElementById("rating").value;
        var productId = <?php echo $product_id; ?>; 
        var userId = <?php echo $userID; ?>; 

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "script/submit-rating.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                console.log(xhr.responseText);
            }
        };
        xhr.send("product_id=" + productId + "&user_id=" + userId + "&rating=" + rating);
    });
});
                    </script>
                    <script src="js/quantity.js">
                    </script>
                    <script src="js/comment.js">
                    </script>
                    <script src="js/like-comment.js">
                        </script>
                </body>
                </html>
