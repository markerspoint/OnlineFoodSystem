<?php
include 'db/database.php';

if (isset($_GET['id'])) {
    $review_id = $_GET['id'];
    $query = "SELECT id, menu_item_id, rating, comment FROM reviews WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $review_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $review = $result->fetch_assoc();
        echo json_encode($review);
    } else {
        echo json_encode(['error' => 'Review not found']);
    }
}
?>
