<?php
include "database.php";

if (isset($_POST['product_id'])) {
    session_start();
    $userID = $_SESSION['user_id'];

    $productId = mysqli_real_escape_string($connection, $_POST['product_id']);

    $deleteSql = "DELETE FROM checkout WHERE product_id = '$productId' AND account_id = '$userID'";

    if (mysqli_query($connection, $deleteSql)) {
        echo "Product deleted successfully";
    } else {
        echo "Error: " . mysqli_error($connection);
    }
} else {
    echo "Product ID is required";
}
?>