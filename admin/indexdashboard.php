<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: adminlogin.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f4f4f9; }
        .header { background: #6c63ff; color: white; padding: 20px; text-align: center; }
        .content { padding: 20px; text-align: center; }
        button { background-color: #6c63ff; color: white; padding: 10px; border: none; border-radius: 5px; cursor: pointer; margin: 10px; }
        button:hover { background-color: #5348c4; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Welcome to the Admin Dashboard</h1>
    </div>
    <div class="content">
        <h2>Admin ID: <?= $_SESSION['admin_id'] ?></h2>
        <button onclick="window.location.href='adminlogin.php';">Logout</button>
        <button onclick="window.location.href='rating.php';">Rating</button>
    </div>
</body>
</html>
