<?php 
include "script/database.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

include "script/logged-in.php";
include "script/is-admin.php";
include "script/show-options.php";

$userID = isset($_GET['id']) ? $_GET['id'] : null;

$sql = "SELECT * FROM accounts INNER JOIN customers ON accounts.id = customers.account_id WHERE accounts.id = $userID";
$result = mysqli_query($connection, $sql);

$userData = mysqli_fetch_assoc($result);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $username = $_POST['username'];
    $address = $_POST['address'];
    $phoneNumber = $_POST['phone_number'];
    $newPassword = $_POST['new_password'];

    $updateAccountSQL = "UPDATE accounts SET email = '$email', username = '$username'";
    if (!empty($newPassword)) {
        // Update password only if a new password is provided
        $updateAccountSQL .= ", password = '$newPassword'";
    }
    $updateAccountSQL .= " WHERE id = $userID";

    $updateCustomerSQL = "UPDATE customers SET address = '$address', phone_number = '$phoneNumber' WHERE account_id = $userID";

    if (mysqli_query($connection, $updateAccountSQL) && mysqli_query($connection, $updateCustomerSQL)) {
        echo "<script>alert('User information updated successfully');</script>";
    } else {
        echo "<script>alert('Failed to update user information');</script>";
    }
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/register.css">
    <title>Edit User | Prototype</title>
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
    <a href="homepage.php">  
        <div class="a-container">
            <h4>Home</h4>
        </div>
    </a>
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
    <a href="store.php"> 
        <div class="a-container">
            <h4>Store</h4>
        </div>
    </a>
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
        <h1 style="color:black;">Edit User Information</h1><br>
        <div class="input-container">
            <input type="text" name="email" placeholder="Email" value="<?php echo $userData['email']; ?>" required>
        </div><br>
        <div class="input-container">
            <input type="text" name="username" placeholder="Full Name" value="<?php echo $userData['username']; ?>" required>
        </div><br>
        <div class="input-container">
            <input type="text" name="address" placeholder="Address" value="<?php echo $userData['address']; ?>" required>
        </div><br>
        <div class="input-container">
            <input type="text" name="phone_number" placeholder="Phone Number" value="<?php echo $userData['phone_number']; ?>" required>
        </div><br>
        <div class="input-container">
            <input type="password" name="new_password" placeholder="New Password" value="<?php echo $userData['password']; ?>">
        </div><br>
        <div class="input-container">
            <input type="submit" value="Update" style="background-color:orange; width:50%;">
        </div><br>
    </form> 
</div>


<div class="footer">
    <h6>All Rights Reserved.</h6>
</div>
</body>
</html>
