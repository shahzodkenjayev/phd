<?php
// backend/public/index.php

require_once '../controllers/UserController.php';

// Foydalanuvchi qo‘shish formasi
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    addUser($_POST['username'], $_POST['password'], $_POST['role'], $_POST['mac_address']);
}

?>
