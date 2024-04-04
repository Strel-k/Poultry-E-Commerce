<?php
include "script/database.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

include "script/logged-in.php";
if(isset($_SESSION['is_admin']) && $_SESSION['is_admin']) {
    include "admin-options.php";
}
// Pagination variables
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$recordsPerPage = 12;
$offset = ($page - 1) * $recordsPerPage;

$search = isset($_GET['search']) ? mysqli_real_escape_string($connection, $_GET['search']) : '';

// Query to fetch products with pagination and search filter
$sql = "SELECT * FROM products";
$countSql = "SELECT COUNT(*) AS total FROM products";

if (!empty($search)) {
    $sql .= " WHERE name LIKE '%$search%'";
    $countSql .= " WHERE name LIKE '%$search%'";
}

$sql .= " LIMIT $offset, $recordsPerPage";
$result = mysqli_query($connection, $sql);

// Total number of products for pagination
$countResult = mysqli_query($connection, $countSql);
$rowCount = mysqli_fetch_assoc($countResult)['total'];
$totalPages = ceil($rowCount / $recordsPerPage);
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/store.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

        <title>Store Page | Prototype</title>
    </head>
    <style>
                        * {
                            text-decoration: none !important;
                        }
                    </style>
    <body>
        <div class="header">
        <a href="homepage.php"> <div class="logo-container">
            <h1 style="color:orange;">NUTRIPAWS</h1>
                <h3>Poultry Farm Solutions</h3> 
            </div></a>
            <a href="admin-deliveries.php"> <div class="a-container">
       <h3>Delivery</h3>
    </div></a>  
            <a href="checkout.php"><div class="a-container"> 
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
            <a href="homepage.php"> <div class="a-container">
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
            <a href="#">  <div class="a-container">
            <h4 style="color:black;">Store</h4>
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
        
    
        <div class="content" style="background-color:orange; padding:15px; width:50%;">
        <form method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <input type="text" name="search" placeholder="Search" class="input-container" value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit" class="search-btn">Search</button>
        </form>
    </div><br>
    
    <div class="content" style="background-color:orange;">
        <div class="best-sellers">
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $rating = $row['rating'];
                    ?>
                    <div class="product-container">
                        <a href="product.php?id=<?php echo $row['id']; ?>">
                            <img src="<?php echo $row['image_url']; ?>" alt="<?php echo $row['name']; ?>" class="product-image">
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
    <?php if ($totalPages > 1): ?>
            <div class="pagination">
                <?php if ($page > 1): ?>
                    <a href="<?php echo $_SERVER['PHP_SELF'] . "?page=" . ($page - 1) . "&search=" . urlencode($search); ?>">Previous</a>
                <?php endif; ?>
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a href="<?php echo $_SERVER['PHP_SELF'] . "?page=" . $i . "&search=" . urlencode($search); ?>" <?php if ($page === $i) echo 'class="active"'; ?>><?php echo $i; ?></a>
                <?php endfor; ?>
                <?php if ($page < $totalPages): ?>
                    <a href="<?php echo $_SERVER['PHP_SELF'] . "?page=" . ($page + 1) . "&search=" . urlencode($search); ?>">Next</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
        <div class="footer">
            <h6>All Rights Reserved.</h6>
        </div>
       
    </body>
    </html>
