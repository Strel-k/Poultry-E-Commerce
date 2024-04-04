<script>

    function RegisterSuccess() {
        alert("Registration Successful!");
    }
    function RegisterUnsuccess() {
        alert("Registration Unsucseful");
    }

</script>

<?php 
include "script/database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $username = $_POST['username'];
    $address = $_POST['address'];
    $phoneNumber = $_POST['phonenumber'];
    $password = $_POST['password'];
    $rePassword = $_POST['re-password'];
    $default_picture="img/Default-Profile-Picture.png";
    if ($password !== $rePassword) {
        echo "Passwords do not match!";
    } else {
        $sql = "INSERT INTO accounts (email, username, password,profile_picture) VALUES ('$email', '$username', '$password','$default_picture')";
        if (mysqli_query($connection, $sql)) {
            $userID = mysqli_insert_id($connection);

            $sql = "INSERT INTO customers (account_id, address, phone_number) VALUES ('$userID', '$address', '$phoneNumber')";
            if (mysqli_query($connection, $sql)) {
                echo "<script>RegisterSuccess();</script>";
            } else {
                echo "<script>RegisterUnsuccess();</script>";
            }
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($connection);
        }
    }
}
include "script/show-options.php";

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <link rel="stylesheet" type="text/css" href="css/register.css">

    <title>Register| Prototype</title>
</head>
<style>
                    * {
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
        <div class="a-container">
            <a href="#"><h3 style="color:orange;">Registration</h3></a>
        </div>
        <a href="login.php"><div class="a-container">
           <h3>Login</h3>
        </div></a>
       
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
    <form method="POST" action="">
        <h1 style="color:black;">Registration Form</h1><br>
        <div class="input-container">
        <input type="text" name="email" placeholder="Email" required>
        </div><br>
        <div class="input-container">
            <input type="text" name="username"placeholder="Full Name" required>
        </div><br>
        <div class="input-container">
            <input type="text" name="address" placeholder="Address" required>
        </div><br>
        <div class="input-container">
            <input type="text" name="phonenumber" placeholder="Phone Number" required>
        </div><br>
        <div class="input-container">
        <input type="password" name="password" placeholder="Password" required>

        </div><br>
        <div class="input-container">
        <input type="password" name="re-password" placeholder="Re-Enter Password" required>

        </div><br>
        <div class="input-container">
        <input type="submit" value="Register" style="background-color:orange; width:50%; "> 
    
        </div><br>
       <a href="login.php"><p>Already Have an Account?</p></a> 
    </form> 

</div>
<div class="footer">
        <h6>All Rights Reserved.</h6>
    </div>
</body>
</html>