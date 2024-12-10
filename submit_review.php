<?php
// Clear any previous output
ob_clean();

// Set proper JSON header
header('Content-Type: application/json');

include 'db/database.php';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form values
    $review_id = $_POST['review_id'];
    $menu_item_id = $_POST['menu_item_id'];
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];

    // If review_id is not empty, we are updating an existing review
    if (!empty($review_id)) {
        // Update review
        $update_query = "UPDATE reviews 
                         SET menu_item_id = ?, rating = ?, comment = ? 
                         WHERE id = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param('iisi', $menu_item_id, $rating, $comment, $review_id);
        if ($stmt->execute()) {
            // Return success as JSON
            echo json_encode([
                'success' => true,
                'id' => $review_id, 
                'rating' => $rating,
                'comment' => $comment
            ]);
            exit; // Prevent any additional output
        } else {
            echo json_encode(['success' => false, 'message' => 'Error updating review: ' . $conn->error]);
            exit;
        }
    } else {
        // Insert new review
        $insert_query = "INSERT INTO reviews (menu_item_id, rating, comment) 
                         VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param('iis', $menu_item_id, $rating, $comment);
        if ($stmt->execute()) {
            // Return success as JSON
            echo json_encode([
                'success' => true,
                'id' => $stmt->insert_id, // Return the new review ID
                'rating' => $rating,
                'comment' => $comment
            ]);
            exit; // Prevent any additional output
        } else {
            echo json_encode(['success' => false, 'message' => 'Error adding review: ' . $conn->error]);
            exit;
        }
    }
} else {
    // If not a POST request, return an error
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}
?>