<?php
include "script/database.php"; // Include your database connection script

$databaseName = "poultry"; // Replace with your database name
$tableName = "accounts"; // Replace with your table name

$sql = "SELECT table_schema, table_name, 
               CONCAT('CREATE TABLE ', table_name, ' (', GROUP_CONCAT(column_name, ' ', column_type SEPARATOR ', '), ')') AS create_statement
        FROM information_schema.columns
        WHERE table_schema = '$databaseName' AND table_name = '$tableName'
        GROUP BY table_name";

$result = $connection->query($sql);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo "Table Creation SQL:<br>";
    echo $row['create_statement'];
} else {
    echo "Error: " . $connection->error;
}

$connection->close();
?>
