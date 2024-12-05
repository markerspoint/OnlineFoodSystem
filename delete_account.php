<?php
session_start();
include 'db/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['password'])) {
    $userId = $_SESSION['id'];
    $password = $_POST['password'];

    // Check if the password matches
    $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (password_verify($password, $user['password'])) {
        // Delete user account
        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $userId);
        if ($stmt->execute()) {
            session_destroy(); // Logout the user
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete account.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Incorrect password.']);
    }
}
?>
