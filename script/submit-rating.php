<?php
include "database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['product_id']) && isset($_POST['user_id']) && isset($_POST['rating'])) {
    $product_id = mysqli_real_escape_string($connection, $_POST['product_id']);
    $user_id = mysqli_real_escape_string($connection, $_POST['user_id']);
    $new_rating = mysqli_real_escape_string($connection, $_POST['rating']);

    $getRatingSql = "SELECT rating FROM products WHERE id = '$product_id'";
    $result = mysqli_query($connection, $getRatingSql);
    $row = mysqli_fetch_assoc($result);
    $current_rating = $row['rating'];

    $new_total_rating = $current_rating + $new_rating;
    $total_ratings = 1;

    $new_average_rating = $new_total_rating / $total_ratings;

    $updateProductSql = "UPDATE products SET rating = '$new_average_rating' WHERE id = '$product_id'";
    mysqli_query($connection, $updateProductSql);

    echo "Rating submitted successfully!";
} else {
    echo "Error: Invalid request.";
}
?>
