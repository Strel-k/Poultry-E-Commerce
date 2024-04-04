<?php
include "database.php"; // Include your database connection script

session_start();

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $userID = $_GET['id'];

    // Delete the corresponding row from the customers table first
    $deleteCustomerSQL = "DELETE FROM customers WHERE account_id = $userID";
    if (mysqli_query($connection, $deleteCustomerSQL)) {
        // After deleting the customer record, delete the account record
        $deleteAccountSQL = "DELETE FROM accounts WHERE id = $userID";
        if (mysqli_query($connection, $deleteAccountSQL)) {
            $_SESSION['flash_message'] = "User profile deleted successfully.";
        } else {
            $_SESSION['flash_message'] = "Failed to delete user profile.";
        }
    } else {
        $_SESSION['flash_message'] = "Failed to delete user profile.";
    }

    // Redirect back to the admin view page after deletion
    header("Location: ../admin-dashboard.php");
    exit();
} else {
    // If user tries to access this script without providing an ID through GET method, redirect them to admin view
    header("Location: ../admin-dashboard.php");
    exit();
}
?>
