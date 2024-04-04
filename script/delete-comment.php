<?php
include "database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['comment_id'])) {
    $comment_id = mysqli_real_escape_string($connection, $_POST['comment_id']);

    $deleteCommentSql = "DELETE FROM comments WHERE id = '$comment_id'";
    if (mysqli_query($connection, $deleteCommentSql)) {
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit();
    } else {
        echo "Error deleting comment: " . mysqli_error($connection);
    }
} else {
    echo "Comment ID not provided.";
}
?>
