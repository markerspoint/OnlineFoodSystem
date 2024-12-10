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
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #1c1b1b; }
        .header { background: #6c63ff; color: white; padding: 20px; text-align: center; }
        .content { padding: 20px; text-align: center; }
        
        /* Default button styles */
        .btn {
            background-color: #ff4d4d; 
            color: white; 
            padding: 12px 20px; 
            border: none; 
            border-radius: 5px; 
            cursor: pointer; 
            margin: 10px; 
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        /* Hover effect for buttons */
        .btn:hover {
            background-color: #e04040 !important;
            transform: translateY(-2px);
        }

        /* Logout button specific styles */
        .btn-logout {
            background-color: #ff4d4d;
        }

        .btn-logout:hover {
            background-color: #e04040;
        }
    </style>
</head>
<body>
    <div class="header" style="background-color: #ff4d4d;">
        <h1>Foodhub Dashboard</h1>
    </div>
    <div class="content">
        <h2 class="admin-id" style="color: #fff">Admin ID: <?= $_SESSION['admin_id'] ?></h2>
        <button class="btn btn-logout" onclick="window.location.href='adminlogin.php';">Logout</button>
        <button class="btn" onclick="window.location.href='rating.php';">Rating</button>
    </div>
</body>
</html>
