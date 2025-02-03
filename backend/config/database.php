<?php
// backend/config/database.php

$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'phd';

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
