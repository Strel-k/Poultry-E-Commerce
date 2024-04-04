<?php

if(isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    
    $sql = "SELECT role FROM accounts WHERE id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if($row['role'] == 1) {
            include "admin-options.php";
        }
    }
}
?>