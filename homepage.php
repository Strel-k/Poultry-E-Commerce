<?php 
include "script/database.php";
error_reporting(E_ALL);
include "script/is-admin.php";
ini_set('display_errors', 1);
session_start();

include "script/logged-in.php";
include "script/show-options.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <title>Prototype | Home Page</title>
</head>
<style>
                    * {
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
        <div class="a-container">
            <a href="#"><h3 style="color:black;">Home</h3></a>
        </div>
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

    <div class="background">
        <i class="fas fa-chevron-left arrow left-arrow" id="left-arrow"></i>
        <i class="fas fa-chevron-right arrow right-arrow" id="right-arrow"></i>

        <img src="img/Content-Background.jpg" class="background-image">
        <div class="image-text">
            <h2 style="font-weight:900; color:white; font-size:45px;">FIND YOUR POULTRY NEEDS HERE</h2><br>
            <a href="about-us.php"><button class="learn-more-btn">Learn more about us</button></a>
        </div>
    </div>
   
    
    <div class="content" style="background-color:orange;">
    <div class="best-sellers">
        <h1 style="color:black;">Store View</h1>
        <p>Select from a wide variety of Products that our customers enjoy!</p>
        <?php
        include "script/database.php";

        $sql = "SELECT * FROM products LIMIT 9"; 
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
        
        <a href="store.php">
            <button class="buy-btn" style="margin-top:5%; border-radius:15px;">Check out our Store!</button>
        </a> 
    </div>
   
    <div class="footer">
        <h6>All Rights Reserved.</h6>
    </div>
    <script src="js/background.js">
       
    </script>
</body>
</html>
