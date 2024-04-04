<?php
session_start();    
include "script/database.php";
include "script/logged-in.php";

if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
include "script/show-options.php";

$userID = $_SESSION['user_id'];
if(isset($_SESSION['is_admin']) && $_SESSION['is_admin']) {
    include "admin-options.php";
}

$sql_checkout_id = "SELECT id FROM checkout WHERE account_id = '$userID'";
$result_checkout_id = mysqli_query($connection, $sql_checkout_id);

if(mysqli_num_rows($result_checkout_id) > 0) {
    $row_checkout_id = mysqli_fetch_assoc($result_checkout_id);
    $checkoutID = $row_checkout_id['id'];
} else {
    echo"<script>alert('You are an Admin!');</script>";
    header("location: homepage.php");
    exit();
}

$sql = "SELECT checkout.*, products.quantity AS product_quantity, products.image_url, products.name AS product_name, products.price, products.rating FROM checkout JOIN products ON checkout.product_id = products.id WHERE checkout.account_id = '$userID'";
$result = mysqli_query($connection, $sql);
$status = "Pending";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    foreach($_POST['product_id'] as $productID) {
        $quantity = $_POST['quantity'][$productID];
        $totalPrice = $_POST['total_price'][$productID];
        
        $insertOrderSql = "INSERT INTO orders (customer_id, productID, checkout_id, total_price, status) 
                           VALUES ('$userID', '$productID', '$checkoutID', '$totalPrice', '$status')";
        $insertOrderResult = mysqli_query($connection, $insertOrderSql);

        if(!$insertOrderResult) {
            echo "Error: " . mysqli_error($connection);
            exit();
        }
    }

    header("Location: homepage.php");
    exit();
}

?>

                <!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

                    <link rel="stylesheet" type="text/css" href="css/checkout.css">
                    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

                    <title>Prototype | Checkout</title>
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
                        <div class="a-container">
                            <a href="#"><h3 style="color:orange;">Checkout</h3></a>
                        </div>
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
                        <a href="about-us.php"><div class="a-container">
                            <h4>About</h4>
                        </div></a>
                        <div class="separator"></div>
                        <div class="a-container">
                            <a href="#"><h4>Portfolio</h4></a>
                        </div>
                        <div class="separator"></div>
                        <a href="store.php"> <div class="a-container">
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
                    <div class="content" style="background-color: orange;">
                <div class="checkout-area">
                    <h1>Checkout</h1>
                    <hr>
                    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <?php
                        if(mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <div class="checkout-container">
                            <div class="product-container">
                            <button type="button" class="remove-product-btn" data-product-id="<?php echo $row['product_id']; ?>"><i class="fas fa-times"></i></button>

                                <input type="checkbox" name="product_id[]" value="<?php echo $row['product_id']; ?>" class="product-checkbox">
                                <img src="<?php echo $row['image_url']; ?>" width="100" height="100">
                                <div class="product-info">
                                    <h5><?php echo $row['product_name']; ?></h5>
                                    <p>Quantity: <?php echo $row['total_quantity']; ?></p>
                                    <p>Cost: P<?php echo $row['total_price']; ?></p> 
                                    <div class="star-rating">
                                        <?php
                                        $rating = $row['rating'];
                                        for ($i = 1; $i <= 5; $i++) {
                                            if ($i <= $rating) {
                                                echo '<i class="fas fa-star"></i>';
                                            } else {
                                                echo '<i class="far fa-star"></i>';
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                                <input type="hidden" name="quantity[<?php echo $row['product_id']; ?>]" value="<?php echo $row['product_quantity']; ?>">
                                <input type="hidden" name="total_price[<?php echo $row['product_id']; ?>]" value="<?php echo $row['price']; ?>">
                            </div>
                        </div>
                        <?php
                            }
                        } else {
                            echo "<p>No items checked out yet.</p>";
                        }
                        ?>
                        <button type="submit" name="submit" class="buy-btn">Buy</button>
                    </form>
                </div>
            </div>
                <br>

                <div class="content" style="background-color:orange;">
                    <div class="best-sellers">
                        <h1 style="color:black;">Best Sellers</h1>
                        <p>Select from a wide variety of Products that our customers enjoy!</p>
                        <?php
                        $sql = "SELECT * FROM products";
                        $result = mysqli_query($connection, $sql);

                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $rating = $row['rating'];
                        ?>
                        <div class="product-container">
                            <a href="product.php?id=<?php echo $row['id']; ?>">
                                <img src="<?php echo $row['image_url']; ?>" alt="<?php echo $row['name']; ?>" width="100" height="100">
                            </a>
                            <h5><?php echo $row['name']; ?></h5>
                            <p>Rating: <?php echo $rating; ?></p>
                            <?php
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
                            echo "<p>No products found.</p>";
                        }
                        ?>
                    </div>
                </div>
                    <div class="footer">
                        <h6>All Rights Reserved.</h6>
                    </div>
                    <script src="js/quantity.js"></script>

                    <script src="js/remove.js"></script>
                </body>
                </html>