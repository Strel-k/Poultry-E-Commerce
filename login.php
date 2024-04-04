<?php 
include "script/database.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start(); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM accounts WHERE (email = '$username' OR username = '$username') AND password = '$password'";
    $result = mysqli_query($connection, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $userID = $row['id'];
        $role = $row['role'];

        $_SESSION['user_id'] = $userID;

        if ($role == 1) {
            header("Location: admin-dashboard.php");
            exit();
        } else {
            header("Location: homepage.php");
            exit();
        }
    } else {
        echo "<script>alert('Invalid Login Credentials/Account does not exist.');</script>";
    }
}
include "script/show-options.php";

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <link rel="stylesheet" type="text/css" href="css/login.css">

    <title>Login | Prototype</title>
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
          
        </div>  </a> 
        <a href="admin-deliveries.php"> <div class="a-container">
       <h3>Delivery</h3>
    </div></a>  
        <a href="checkout.php">
            <div class="a-container"> 
                <h3>Checkout</h3>
            </div>
        </a>
        <a href="register.php"> <div class="a-container">
            <h3>Registration</h3>
        </div></a>
        <a href="#"><div class="a-container">
           <h3 style="color:orange;">Login</h3>
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
        <h1 style="color:black;">Login Form</h1><br>
        <div class="input-container">
        <input type="text" name="username" placeholder="Email/Username">
        </div><br>
        <div class="input-container">
            <input type="password" name="password" placeholder="Password">
        </div><br>
        <div class="input-container">
        <input type="submit" value="login" style="background-color:orange; width:50%; margin-left:22%;"> 
    
        </div><br>
       <a href="register.php"><p>Don't have an account?</p></a> 
    </form> 

</div>
<div class="footer">
        <h6>All Rights Reserved.</h6>
    </div>
</body>
</html>