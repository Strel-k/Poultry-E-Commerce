
<?php 
include "script/database.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

include"script/logged-in.php";
include "script/show-options.php";

?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

        <link rel="stylesheet" type="text/css" href="css/about-us.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

        <title>Prototype | About Us</title>
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
            <a href="homepage.php"><div class="a-container">
            <h4>Home</h4>
            </div></a>
            <div class="separator"></div> 
            <a href="about-us.php"><div class="a-container">
            <h3 style="color:black;">About</h3>
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

        <div class="background">

            <img src="img/Content-Background2.jpg" class="background-image">
            <div class="image-text">
                <h2 style="font-weight:900; color:white; font-size:45px; text-align: center;">SERVING THE NATION'S POULTRY INDUSTRY</h2><br>
            </div>
        </div>

        <div class="content" style="background-color:orange; top:10px;">
                <div class="image-container">
                    <img src="img/Chicken.png" width="350" height="400">
            </div>
            <div class="text-container">
                    <h1>About Us</h1>
                    <h2> Welcome to our humble store</h2><br>
                    <p>We Serve High Quality Products </p><br>
                    <p>Aided by the top Agriculturist in the country</p><br>
                    <p> We Wish to bring your Poultry needs to your doorstep!</p><br>
                </div>
            <button class="buy-btn"><a href="store.php">Visit our Store</button></a> 
        </div>
        <div class="content" style="background-color: rgba(255, 166, 0, 0.555);">
        <div class="header-wrapper">
            <h1 >Why Choose Us?</h1>
        </div>
            <div class="image-container-wrapper" style="margin-top:10%;">
                
                <div class="image-container">
                    <img src="img/Chicken-why-choose.png" with="100" height="100">
                <div class="text-container">
                    <p style="margin-top:15px; font-size:25px;">Convenience</p>
                </div>
                </div>
                <div class="image-container">
                    <img src="img/Award-ribbon-why-choose-us.png" with="100" height="100">
                <div class="text-container">
                    <p style="margin-top:28px;margin-left:15px;font-size:25px;">Quality Assurance</p>
                </div>
                </div>
                <div class="image-container">
                    <img src="img/Delivery-why-choose-us.png" with="100" height="110">
                <div class="text-container">
                    <p style="margin-top:15px; font-size:25px;">Delivery on-time</p>
                </div>
                </div>
            </div>
        </div>
        <div class="content-founders">
            <div class="founders">
                <h1>Founders</h1>
                <div class="image-container">
                    <div style="    justify-content: space-around;
                    ">
                        <img src="img/Profile-picture2.jpg" width="250" height="350">
                        <img src="img/Profile-picture1.jpg" width="250" height="350">
                        <img src="img/Profile-picture3.jpg" width="250" height="350">
                    </div>
                
                </div>
                
            </div>
        </div>
        <div class="content" style="background-color: rgba(255, 166, 0, 0.555);">
            <div class="vision-mission-goal" style="justify-content: space-around;">
                <div class="mission-container">
                    <h1>Mission</h1>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed consequat, turpis ut viverra eleifend.</p>
                </div>
                <div class="mission-container">
                    <h1>Vision</h1>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed consequat, turpis ut viverra eleifend.</p>

                </div>
                <div class="mission-container">
                    <h1>Goal</h1>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed consequat, turpis ut viverra eleifend.</p>

                </div>
            </div>
        </div>
            <div class="footer">
            <h6>All Rights Reserved.</h6>
        </div>
        <script>
            const backgroundImages = ["img/Content-Background.jpg", "img/Content-Background2.jpg","img/Content-Background3.jpg"]; // Add more images if needed
            let currentImageIndex = 0;

            document.getElementById('left-arrow').addEventListener('click', function() {
                currentImageIndex = (currentImageIndex - 1 + backgroundImages.length) % backgroundImages.length;
                updateBackgroundImage();
            });

            document.getElementById('right-arrow').addEventListener('click', function() {
                currentImageIndex = (currentImageIndex + 1) % backgroundImages.length;
                updateBackgroundImage();
            });

            function updateBackgroundImage() {
                const backgroundImage = document.querySelector('.background-image');
                backgroundImage.src = backgroundImages[currentImageIndex];
            }
        </script>
    </body>
    </html>
