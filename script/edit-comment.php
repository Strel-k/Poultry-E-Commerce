<?php
include "database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['comment_id']) && isset($_POST['edited_comment'])) {
    $comment_id = mysqli_real_escape_string($connection, $_POST['comment_id']);
    $edited_comment = mysqli_real_escape_string($connection, $_POST['edited_comment']);

    $updateCommentSql = "UPDATE comments SET comment = '$edited_comment' WHERE id = '$comment_id'";
    if (mysqli_query($connection, $updateCommentSql)) {
        // Fetch the product ID associated with the edited comment
        $fetchProductIdSql = "SELECT product_id FROM comments WHERE id = '$comment_id'";
        $result = mysqli_query($connection, $fetchProductIdSql);
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $product_id = $row['product_id'];
            // Redirect back to the product page with the correct product ID
            header("Location: ../product.php?id=$product_id");
            exit();
        } else {
            // Handle case where product ID cannot be retrieved
            echo "Error: Product ID not found.";
            exit();
        }
    } else {
        echo "Error: " . mysqli_error($connection);
        exit();
    }
} else {
    echo "Error: Required data not provided.";
    exit();
}
?>
