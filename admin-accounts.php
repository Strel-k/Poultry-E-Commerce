<?php 
include "script/database.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

include "script/logged-in.php";
include "script/is-admin.php";
include "script/show-options.php";

$search = isset($_GET['search']) ? mysqli_real_escape_string($connection, $_GET['search']) : '';

$limit = 12; 
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1; // Current page number
$offset = ($page - 1) * $limit; 
$sql = "SELECT accounts.*, customers.* 
        FROM accounts 
        INNER JOIN customers ON accounts.id = customers.account_id";

if (!empty($search)) {
    $sql .= " WHERE accounts.username LIKE '%$search%'"; // Adjust the search condition as needed
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
    <div class="a-container">
        <a href="#"><h3>Delivery</h3></a>  
    </div>
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

<div class="content" style="background-color:orange; width:50%;">
    <div class="best-sellers">
        <?php
        include "script/database.php";

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $profilePicture = $row['profile_picture'];
                ?>
                <div class="product-container" style="position: relative;">
                    <img src="<?php echo $profilePicture; ?>" alt="Profile Picture" height="60" width="55">
                    <h5><?php echo $row['username']; ?></h5>
                    <p>Email: <?php echo $row['email']; ?></p>
                    <p>Address: <?php echo $row['address']; ?></p>
                    <a href="script/delete-profile.php?id=<?php echo $row['account_id']; ?>" class="delete-button" onclick="return confirm('Are you sure you want to delete this profile?')">Delete</a>
                    <a href="admin-account-update.php?id=<?php echo $row['account_id']; ?>" class="edit-button">Update</a>
                </div>
                <?php
            }
        } else {
            echo "<p>No accounts found.</p>";
        }
        ?>
        <br>
        <a href="register.php" class="add-product-link">
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
