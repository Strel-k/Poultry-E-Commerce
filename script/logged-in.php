<?php 
include "database.php";


if(isset($_SESSION['user_id'])) {
    $userID = $_SESSION['user_id']; 
    $sql = "SELECT customers.*, accounts.username AS full_name, accounts.profile_picture 
            FROM customers 
            INNER JOIN accounts ON customers.account_id = accounts.id 
            WHERE customers.account_id = '$userID'";
    $result = mysqli_query($connection, $sql);

    if(mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $fullName = $row['full_name'];
        $profilePicture = $row['profile_picture'];
    }
}

if(isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}
?>