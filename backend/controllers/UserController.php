<?php
require_once '../config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $mac_address = $_POST['mac_address'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = intval($_POST['role']);

    if ($role < 1 || $role > 20) {
        die("Noto'g'ri rol!");
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO user (username, mac_address, password, role) VALUES (?, ?, ?, ?)");
        $stmt->execute([$username, $mac_address, $password, $role]);
        header("Location: ../views/admin_panel.php");
    } catch (PDOException $e) {
        die("Xatolik: " . $e->getMessage());
    }
}
?>
