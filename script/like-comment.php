<?php
include "database.php";
session_start();
header('Content-Type: application/json');

// Check if the request method is POST and if the required data is sent
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['comment_id']) && isset($_SESSION['user_id'])) {
    // Sanitize input data
    $comment_id = mysqli_real_escape_string($connection, $_POST['comment_id']);
    $user_id = mysqli_real_escape_string($connection, $_SESSION['user_id']);

    // Validate user authentication
    if (!isValidUser($user_id)) {
        echo json_encode(['success' => false, 'message' => 'User not authenticated']);
        exit();
    }

    // Check if the user already liked the comment
    $check_like_sql = "SELECT COUNT(*) as total_likes FROM comment_likes WHERE comment_id = '$comment_id' AND user_id = '$user_id'";
    $check_like_result = mysqli_query($connection, $check_like_sql);

    if (!$check_like_result) {
        // Handle database error
        $error_message = mysqli_error($connection);
        echo json_encode(['success' => false, 'message' => 'Database error', 'error' => $error_message]);
        exit();
    }

    $check_like_row = mysqli_fetch_assoc($check_like_result);
    $total_likes = intval($check_like_row['total_likes']);

    if ($total_likes == 0) {
        // Insert a new like
        $insert_like_sql = "INSERT INTO comment_likes (comment_id, user_id) VALUES ('$comment_id', '$user_id')";
        $message = 'Liked';
    } else {
        // Delete the existing like
        $delete_like_sql = "DELETE FROM comment_likes WHERE comment_id = '$comment_id' AND user_id = '$user_id'";
        $message = 'Unliked';
    }

    // Get the updated total likes count
    $get_total_likes_sql = "SELECT COUNT(*) as total_likes FROM comment_likes WHERE comment_id = '$comment_id'";
    $get_total_likes_result = mysqli_query($connection, $get_total_likes_sql);

    if (!$get_total_likes_result) {
        // Handle database error
        $error_message = mysqli_error($connection);
        echo json_encode(['success' => false, 'message' => 'Database error', 'error' => $error_message]);
        exit();
    }

    $total_likes_row = mysqli_fetch_assoc($get_total_likes_result);
    $total_likes = intval($total_likes_row['total_likes']);

    // Update the likes count in the comments table
    $update_likes_sql = "UPDATE comments SET likes = '$total_likes' WHERE id = '$comment_id'";
    $update_result = mysqli_query($connection, $update_likes_sql);

    if (!$update_result) {
        // Handle database error
        $error_message = mysqli_error($connection);
        echo json_encode(['success' => false, 'message' => 'Database error', 'error' => $error_message]);
        exit();
    }

    // Send the response
    echo json_encode(['success' => true, 'message' => $message, 'total_likes' => $total_likes]);
} else {
    // Invalid request
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}

function isValidUser($user_id) {
    global $connection; // Assuming $connection is your database connection variable

    $user_id = mysqli_real_escape_string($connection, $user_id);
    $query = "SELECT id FROM users WHERE id = '$user_id'";
    $result = mysqli_query($connection, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        return true;
    } else {
        // User does not exist or is not authenticated
        return false;
    }
}
?>
