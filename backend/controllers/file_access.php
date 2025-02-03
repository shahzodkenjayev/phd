<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['user_id'])) {
    die("Avval tizimga kiring.");
}

$user_role = $_SESSION['role'];
$file_path = $_POST['file_path'];
$file_name = $_POST['file_name'];
$file_role = intval($_POST['role']);

if ($file_role < 1 || $file_role > 20) {
    die("Noto'g'ri fayl roli!");
}

// Faylga ruxsat berish
if ($user_role >= $file_role) {
    echo "Ruxsat berildi! Faylni yuklash mumkin.";
} else {
    echo "Sizga bu faylni yuklashga ruxsat yo'q!";
}
?>
