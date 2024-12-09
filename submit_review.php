<?php
include 'db/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $menu_item_id = $_POST['menu_item'];
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];
    $user_id = $_SESSION['id']; // Assuming the user is logged in and their ID is stored in session

    // Insert the review into the database
    $stmt = $pdo->prepare("INSERT INTO Reviews (user_id, menu_item_id, rating, comment, created_at) 
                           VALUES (:user_id, :menu_item_id, :rating, :comment, NOW())");
    $stmt->execute([
        ':user_id' => $user_id,
        ':menu_item_id' => $menu_item_id,
        ':rating' => $rating,
        ':comment' => $comment
    ]);

    header("Location: review.php"); // Redirect back to the reviews page
    exit;
}
?>