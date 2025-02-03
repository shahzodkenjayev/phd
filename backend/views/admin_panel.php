<?php
require_once '../config/database.php';

// Foydalanuvchilarni chiqarish
$stmt = $pdo->query("SELECT id, username, mac_address, role FROM user");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="../../client/css/style.css">
</head>
<body>
    <h2>Foydalanuvchilar ro'yxati</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Foydalanuvchi nomi</th>
            <th>MAC manzil</th>
            <th>Roli</th>
        </tr>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $user['id'] ?></td>
                <td><?= htmlspecialchars($user['username']) ?></td>
                <td><?= htmlspecialchars($user['mac_address']) ?></td>
                <td><?= $user['role'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h2>Yangi foydalanuvchi qo'shish</h2>
    <form action="../controllers/UserController.php" method="post">
        <input type="text" name="username" placeholder="Foydalanuvchi nomi" required>
        <input type="text" name="mac_address" placeholder="MAC manzil" required>
        <input type="password" name="password" placeholder="Parol" required>
        <input type="number" name="role" placeholder="Roli (1-20)" min="1" max="20" required>
        <button type="submit">Qo'shish</button>
    </form>
</body>
</html>
