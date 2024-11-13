<?php 
$host = "localhost";
$username = "root";
$password = ""; // Leave it empty if you haven't set a MySQL password
$database = "discuss";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
