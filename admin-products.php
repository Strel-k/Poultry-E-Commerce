<?php 
include "script/database.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

include "script/logged-in.php";
include "script/is-admin.php";

$search = isset($_GET['search']) ? mysqli_real_escape_string($connection, $_GET['search']) : '';
include "script/show-options.php";

// Pagination variables
$limit = 12; // Number of products per page
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1; // Current page number
$offset = ($page - 1) * $limit; // Offset for the SQL query

$sql = "SELECT * FROM products";
if (!empty($search)) {
    $sql .= " WHERE name LIKE '%$search%'";
}

// Add pagination limit and offset
$sql .= " LIMIT $limit OFFSET $offset";

$result = mysqli_query($connection, $sql);

$flashMessage = '';
if (isset($_SESSION['flash_message'])) {
    $flashMessage = $_SESSION['flash_message'];
    unset($_SESSION['flash_message']); 
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <link rel="stylesheet" type="text/css" href="css/admin-view.css">

    <title>Admin Products | Prototype</title>
</head>
<style>
    a {
        text-decoration: none !important;
    }
</style>
<body>
<div class="header">
    <div class="logo-container">
        <a href="#">
            <h1 style="color:orange;">NUTRIPAWS</h1>
            <h3>Poultry Farm Solutions</h3>
        </a> 
    </div>
    <a href="admin-deliveries.php"> <div class="a-container">
       <h3>Delivery</h3>
    </div></a>  
    <a href="checkout.php">
        <div class="a-container"> 
            <h3>Checkout</h3>
        </div>
    </a>
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
        <a href="about-us.php">
            <div class="a-container">
                <h4>About</h4>
            </div>
        </a>
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
    <div class="content" style="background-color:orange;">
    <div class="best-sellers">
        <?php
        include "script/database.php";

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $rating = $row['rating'];
                ?>
                <div class="product-container" style="position: relative;"> <!-- Add position: relative -->
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
                    <br>
                    <a href="admin-product-edit.php?id=<?php echo $row['id']; ?>" class="edit-button">Edit</a>
                    <a href="script/delete-product.php?id=<?php echo $row['id']; ?>" class="delete-button" onclick="return confirm('Are you sure you want to delete this product?')">Delete</a>

                </div>
                <?php
            }
        } else {
            echo "<p>No products found.</p>";
        }
        ?>
        <br>
        <a href="admin-add-products.php" class="add-product-link">
            <button class="buy-btn">+</button>
        </a>
    </div>
</div>
<div class="pagination">
    <?php if ($page > 1): ?>
        <a href="?page=<?php echo $page - 1; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>">Previous</a>
    <?php endif; ?>
    
    <?php if (mysqli_num_rows($result) > 0): ?>
        <span>Page <?php echo $page; ?></span>
    <?php endif; ?>
    
    <?php if (mysqli_num_rows($result) >= $limit): ?>
        <a href="?page=<?php echo $page + 1; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>">Next</a>
    <?php endif; ?>
</div>
        <div class="footer">
            <h6>All Rights Reserved.</h6>
        </div>
</body>
</html>