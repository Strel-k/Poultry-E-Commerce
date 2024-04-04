<?php
include "database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $order_id = $_POST["order_id"];
    $new_status = $_POST["status"];

    $update_sql = "UPDATE orders SET status = '$new_status' WHERE id = $order_id";
    $connection->query($update_sql);

    if ($new_status === "Delivered" || $new_status === "Cancelled") {
        $delete_sql = "DELETE FROM checkout WHERE id = $order_id";
        $connection->query($delete_sql);
    }

    // Redirect back to the page where the status was updated
    header("Location: ../admin-deliveries.php");
    exit();
}
?>
