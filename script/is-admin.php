<?php
include "database.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "logged-in.php";

if(isset($_SESSION['id'])) {
    $user_id = $_SESSION['id'];
    
    $sql = "SELECT role FROM accounts WHERE user_id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $user_role = $row['role'];
        
    } else {
        $user_role = 0; 
    }
} else {
    $user_role = 0;
}
?>