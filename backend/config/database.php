<?php
$host = 'localhost';
$dbname = 'proxy_filter';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Bazaga ulanishda xatolik: " . $e->getMessage());
}
?>
