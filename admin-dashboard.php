<?php 
include "script/database.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include "script/logged-in.php";
include "script/is-admin.php";
include "script/show-options.php";

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/admin.css">

    <title>Admin Dashboard | Prototype</title>
</head>
<style>
    a {
        text-decoration: none !important;
    }
</style>
<body>
<div class="header">
    <div class="logo-container">
        <a href="homepage.php">
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
    <div class="dashboard">
  <a href="admin-deliveries.php"> <div class="content">
        <h1>Deliveries</h1>
        <div class="image-container">
            <img src="img/Delivery-why-choose-us.png" width="80" height="100">
        </div>
    </div></a> 
  <a href="admin-products.php"> <div class="content">
        <h1>Products</h1>
        <div class="image-container">
            <img src="img/Chicken-why-choose.png" width="80" height="100">
        </div>
    </div></a> 
   <a href="admin-accounts.php"><div class="content">
        <h1>Accounts</h1>
        <div class="image-container">
                <img src="img/Accounts.png" width="80" height="100">
            </div>
    </div></a> 
    </div>
    <br>
  
</body>
</html>