<?php
session_start();
include "database.php";

if(isset($_GET['id'])) {
    $productId = $_GET['id'];
    
    // Retrieve the image URL from the database
    $getImageQuery = "SELECT image_url FROM products WHERE id = $productId";
    $imageResult = mysqli_query($connection, $getImageQuery);
    $row = mysqli_fetch_assoc($imageResult);
    $imageUrl = $row['image_url'];
    
    // Delete the image file from the uploads folder
    if ($imageUrl) {
        $uploadPath = "../" . $imageUrl; // Assuming uploads folder is one level above the current directory
        if (file_exists($uploadPath)) {
            unlink($uploadPath); // Delete the file
        }
    }
    
    // Delete the product from the database
    $deleteQuery = "DELETE FROM products WHERE id = $productId";
    if(mysqli_query($connection, $deleteQuery)) {
        $_SESSION['flash_message'] = "Product deleted successfully";
    } else {
        $_SESSION['flash_message'] = "Error deleting product: " . mysqli_error($connection);
    }
    
    header("Location: ../admin-products.php");
    exit();
} else {
    echo "Invalid request";
}
?>
