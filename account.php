<?php 
session_start();    

include "script/database.php";
include "script/logged-in.php";
include "script/show-options.php";

$userID = $_SESSION['user_id'];
$sql = "SELECT accounts.*, customers.*
        FROM accounts
        INNER JOIN customers ON accounts.id = customers.account_id
        WHERE accounts.id = '$userID'";
$result = mysqli_query($connection, $sql);

// Check if user details are retrieved successfully
if ($result && mysqli_num_rows($result) > 0) {
    $userData = mysqli_fetch_assoc($result);
    // Extract user details
    $fullName = $userData['username'];
    $profilePicture = $userData['profile_picture'];
    // Additional user details from customers table
    $email = $userData['email'];
    $address=$userData['address'];
    $phone_number=$userData['phone_number'];
    // Add more fields as needed
} else {
    // Redirect to homepage or display an error message
    header("Location: homepage.php");
    exit();
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <link rel="stylesheet" type="text/css" href="css/account.css">

    <title>Account | Prototype</title>
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
    <div class="a-container">
        <a href="#"><h3>Delivery</h3></a>  
    </div>
    <a href="checkout.php">
        <div class="a-container">
            <h3>Checkout</h3>
        </div>
    </a>
    <?php if(isset($_SESSION['user_id'])): ?>
        <a href="script/logout.php">
            <div class="a-container">
                <h3>Logout</h3>
            </div>
        </a>
        <div class="user-info">
            <p><?php echo $fullName; ?></p>
            <img src="<?php echo $profilePicture; ?>" alt="Profile Picture" height="60" width="55">
        </div>
    <?php else: ?>
        <a href="register.php">
            <div class="a-container">
                <h3>Registration</h3>
            </div>
        </a>
        <a href="login.php">
            <div class="a-container">
                <h3>Login</h3>
            </div>
        </a>
    <?php endif; ?>
</div>

<div class="header" style="background-color: orange;">
    <a href="homepage.php">
        <div class="a-container">
            <h4>Home</h4>
        </div>
    </a>
    <div class="separator"></div> 
    <a href="about-us.php">
        <div class="a-container">
            <h3>About</h3>
        </div>
    </a>
    <div class="separator"></div>
    <div class="a-container">
        <a href="#">
            <h4>Portfolio</h4>
        </a>
    </div>
    <div class="separator"></div>
    <a href="store.php">
        <div class="a-container">
            <h4>Store</h4>
        </div>
    </a>
    <div class="separator"></div>
    <div class="a-container">
        <a href="#">
            <h4>Blog</h4>
        </a>
    </div>
    <div class="separator"></div>
    <div class="a-container">
        <a href="#">
            <h4>Contact</h4>
        </a>
    </div>
</div>
<div class="content" style="background-color: orange;">
    <h1>Welcome, <?php echo $fullName; ?></h1>
    <img src="<?php echo $profilePicture; ?>" alt="Profile Picture" height="100" width="100"><br>
    <!-- Display other user details here -->
    <p>Email: <?php echo $email; ?></p><br>
    <p>Address: <?php echo $address; ?></p>
    <br> <p>Phone Number: <?php echo $phone_number; ?></p>

    <!-- Add more fields as needed -->
</div>
<br>
<div class="footer">
    <h6>All Rights Reserved.</h6>
</div>
</body>
</html>
