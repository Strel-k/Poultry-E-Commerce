<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <link rel="stylesheet" type="text/css" href="css/portfolio.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <title>Portfolio | Prototype</title>
</head>
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
        <a href="checkout.html">
            <div class="a-container"> 
                <h3>Checkout</h3>
            </div>
        </a>
        <div class="a-container">
            <a href="#"><h3>Registration</h3></a>
        </div>
        <div class="a-container">
            <a href="#"><h3>Login</h3></a>
        </div>
       
    </div>

    <div class="header" style="background-color: orange; ">
        <div class="a-container">
            <a href="#"><h3 style="color:black;">Home</h3></a>
        </div>
        <div class="separator"></div> 
        <a href="about-us.html">
            <div class="a-container">
                <h4>About</h4>
            </div>
        </a>
        <div class="separator"></div>
        <div class="a-container">
            <a href="#"><h4>Portfolio</h4></a>
        </div>
        <div class="separator"></div>
        <div class="a-container">
            <a href="#"><h4>Store</h4></a>
        </div>
        <div class="separator"></div>
        <div class="a-container">
            <a href="#"><h4>Blog</h4></a>
        </div>
        <div class="separator"></div>
        <div class="a-container">
            <a href="#"><h4>Contact</h4></a>
        </div>
    </div>

   
    <div class="content" style="background-color: orange; padding:15%;    border-radius:15px;
    ">
    <div class="portfolio-header">
        <h1> Portfolio</h1>

    </div>
    <div class="portfolio">
        <div class="image-container">
            <img src="img/Portfolio-1.jpg" width="350" height="310">
            <div class="portfolio-text">
                <h2>Lorem Ipsum</h2>
                <p>Lorem Ipsum Lorem Ipsum Lorem IpsumLorem Ipsum </p>
                <p>Lorem IpsumLorem IpsumLorem IpsumLorem Ipsum</p>
            </div>
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
