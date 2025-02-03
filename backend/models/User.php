<?php
// backend/models/User.php

require_once '../config/database.php';

function getUserById($userId) {
    global $conn;
    $query = "SELECT * FROM user WHERE id = $userId";
    return $conn->query($query)->fetch_assoc();
}
?>
