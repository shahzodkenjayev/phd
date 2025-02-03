<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'your_database_name');

// Foydalanuvchi qo‘shish
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_user'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $mac_address = $_POST['mac_address'];

    $password_hash = password_hash($password, PASSWORD_BCRYPT);  // Parolni shifrlash

    $query = "INSERT INTO users (username, password, role, mac_address) VALUES ('$username', '$password_hash', '$role', '$mac_address')";
    $conn->query($query);
    echo "Foydalanuvchi qo'shildi!";
}

// Foydalanuvchi ro‘llari va ma'lumotlar
$users_query = "SELECT * FROM users";
$users_result = $conn->query($users_query);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
</head>
<body>
    <h1>Foydalanuvchi Qo‘shish</h1>
    <form method="POST">
        <label for="username">Foydalanuvchi nomi:</label>
        <input type="text" name="username" required><br>
        <label for="password">Parol:</label>
        <input type="password" name="password" required><br>
        <label for="role">Rol:</label>
        <input type="number" name="role" min="1" max="20" required><br>
        <label for="mac_address">MAC Manzili:</label>
        <input type="text" name="mac_address" required><br>
        <button type="submit" name="add_user">Qo‘shish</button>
    </form>

    <h2>Foydalanuvchilar ro‘yxati:</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Foydalanuvchi nomi</th>
            <th>Rol</th>
            <th>MAC Manzili</th>
        </tr>
        <?php while ($user = $users_result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $user['id']; ?></td>
            <td><?php echo $user['username']; ?></td>
            <td><?php echo $user['role']; ?></td>
            <td><?php echo $user['mac_address']; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
