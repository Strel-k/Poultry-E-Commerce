<?php
include "database.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_order'])) {
    $orderId = $_POST['order_id'];

    $deleteOrderQuery = "DELETE FROM orders WHERE id = ?";
    $deleteOrderStatement = mysqli_prepare($connection, $deleteOrderQuery);
    mysqli_stmt_bind_param($deleteOrderStatement, "i", $orderId);
    mysqli_stmt_execute($deleteOrderStatement);

    $deleteCheckoutQuery = "DELETE FROM checkout WHERE id = ?";
    $deleteCheckoutStatement = mysqli_prepare($connection, $deleteCheckoutQuery);
    mysqli_stmt_bind_param($deleteCheckoutStatement, "i", $orderId);
    mysqli_stmt_execute($deleteCheckoutStatement);

    header("Location: ../admin-deliveries.php?delete_error=0");
    exit();
} else {
    header("Location: ../admin-deliveries.php?delete_error=1");
    exit();
}
?>
