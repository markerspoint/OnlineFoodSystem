<?php
include '../db/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Delete review functionality
    if (isset($_POST['delete_id'])) {
        $delete_id = $_POST['delete_id'];
        $sql = "DELETE FROM reviews WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $delete_id);

        if ($stmt->execute()) {
            echo "<script>alert('Review deleted successfully!'); window.location.href='rating.php';</script>";
        } else {
            echo "<script>alert('Failed to delete review.');</script>";
        }
        $stmt->close();
    }

    // Edit review functionality
    if (isset($_POST['edit_id'])) {
        $edit_id = $_POST['edit_id'];
        $new_comment = $_POST['comment'];

        $sql = "UPDATE reviews SET comment = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $new_comment, $edit_id);

        if ($stmt->execute()) {
            echo "<script>alert('Comment updated successfully!'); window.location.href='rating.php';</script>";
        } else {
            echo "<script>alert('Failed to update comment.');</script>";
        }
        $stmt->close();
    }

    // Add new review functionality
    if (isset($_POST['add_review'])) {
        $menu_item_id = $_POST['menu_item_id'];
        $rating = $_POST['rating'];
        $comment = $_POST['comment'];

        $sql = "INSERT INTO reviews (menu_item_id, rating, comment) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iis", $menu_item_id, $rating, $comment);

        if ($stmt->execute()) {
            echo "<script>alert('Review added successfully!'); window.location.href='rating.php';</script>";
        } else {
            echo "<script>alert('Failed to add review.');</script>";
        }
        $stmt->close();
    }
}

// Fetch reviews and menu items
$sql = "SELECT r.id, r.menu_item_id, r.rating, r.comment, r.created_at, m.name AS menu_name
        FROM reviews r
        JOIN menuitems m ON r.menu_item_id = m.id";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ratings and Reviews</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f4f4f9; }
        .container { margin: 20px auto; max-width: 800px; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2); }
        h2 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        table th, table td { border: 1px solid #ddd; padding: 8px; text-align: center; }
        table th { background: #6c63ff; color: white; }
        .delete-btn, .edit-btn, .add-btn { color: white; border: none; padding: 5px 10px; border-radius: 5px; cursor: pointer; }
        .delete-btn { background-color: #ff4d4d; }
        .delete-btn:hover { background-color: #d73838; }
        .edit-btn { background-color: #4caf50; }
        .edit-btn:hover { background-color: #3e8e41; }
        .add-btn { background-color: #6c63ff; }
        .add-btn:hover { background-color: #5348c4; }
        .modal { display: none; position: fixed; z-index: 1; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0, 0, 0, 0.5); }
        .modal-content { background-color: #fff; margin: 15% auto; padding: 20px; border: 1px solid #888; width: 50%; border-radius: 8px; }
        .modal-close { float: right; color: #aaa; font-size: 28px; font-weight: bold; cursor: pointer; }
        .modal-close:hover, .modal-close:focus { color: black; text-decoration: none; cursor: pointer; }
        .save-btn { background-color: #6c63ff; color: white; border: none; padding: 10px 15px; border-radius: 5px; cursor: pointer; }
        .save-btn:hover { background-color: #5348c4; }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }

        .container {
            margin: 20px auto;
            max-width: 500px;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .add-btn, .save-btn {
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .add-btn {
            background-color: #6c63ff;
        }

        .add-btn:hover {
            background-color: #5348c4;
        }

        .save-btn {
            background-color: #6c63ff;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
        }

        .save-btn:hover {
            background-color: #5348c4;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: #fff;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 50%;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .modal-close {
            float: right;
            color: #aaa;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .modal-close:hover,
        .modal-close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
            display: inline-block;
            font-size: 16px;
        }

        select, input, textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        textarea {
            resize: vertical;
        }

        .modal-content form {
            display: flex;
            flex-direction: column;
        }

        .modal-content form button {
            width: 100%;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="indexdashboard.php" style="display: inline-block; margin-bottom: 20px; text-decoration: none; background-color: #e04040; color: white; padding: 10px 15px; border-radius: 5px;">Back</a>
        <button class="add-btn" onclick="openAddReviewModal()">Add Review</button> <!-- Add Review button -->
        <h2>Ratings and Reviews</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Menu Item ID and Name</th>
                    <th>Rating</th>
                    <th>Comment</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= $row['menu_item_id'] . " - " . htmlspecialchars($row['menu_name']) ?></td>
                            <td><?= $row['rating'] ?></td>
                            <td><?= htmlspecialchars($row['comment']) ?></td>
                            <td><?= $row['created_at'] ?></td>
                            <td>
                                <form method="POST" style="display: inline;">
                                    <input type="hidden" name="delete_id" value="<?= $row['id'] ?>">
                                    <button type="submit" class="delete-btn">Delete</button>
                                </form>
                                <button class="edit-btn" onclick="openEditModal(<?= $row['id'] ?>, '<?= htmlspecialchars($row['comment']) ?>')">Edit</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">No reviews found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Add Review Modal -->
    <div id="addReviewModal" class="modal">
        <div class="modal-content">
            <span class="modal-close" onclick="closeAddReviewModal()">&times;</span>
            <h2>Add Review</h2>
            <form method="POST">
                <label for="menu_item_id">Menu Item:</label>
                <select id="menu_item_id" name="menu_item_id" required>
                    <?php
                    $menu_sql = "SELECT id, name FROM menuitems";
                    $menu_result = $conn->query($menu_sql);
                    while ($menu_row = $menu_result->fetch_assoc()):
                    ?>
                        <option value="<?= $menu_row['id'] ?>"><?= htmlspecialchars($menu_row['name']) ?></option>
                    <?php endwhile; ?>
                </select>
                <br>
                <label for="rating">Rating:</label>
                <input type="number" id="rating" name="rating" min="1" max="5" required>
                <br>
                <label for="comment">Comment:</label>
                <textarea id="comment" name="comment" rows="4" required></textarea>
                <br>
                <button type="submit" name="add_review" class="save-btn">Submit Review</button>
            </form>
        </div>
    </div>

    <!-- Edit Review Modal -->
    <div id="editReviewModal" class="modal">
        <div class="modal-content">
            <span class="modal-close" onclick="closeEditReviewModal()">&times;</span>
            <h2>Edit Review</h2>
            <form method="POST">
                <input type="hidden" id="edit_id" name="edit_id">
                <label for="edit_comment">Comment:</label>
                <textarea id="edit_comment" name="comment" rows="4" required></textarea>
                <br>
                <button type="submit" name="edit_review" class="save-btn">Save Changes</button>
            </form>
        </div>
    </div>

    <script>
        function openAddReviewModal() {
            document.getElementById('addReviewModal').style.display = 'block';
        }

        function closeAddReviewModal() {
            document.getElementById('addReviewModal').style.display = 'none';
        }

        function openEditModal(id, comment) {
            document.getElementById('editReviewModal').style.display = 'block';
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_comment').value = comment;
        }

        function closeEditReviewModal() {
            document.getElementById('editReviewModal').style.display = 'none';
        }

        // Close modal when clicking outside of it
        window.onclick = function(event) {
            const addModal = document.getElementById('addReviewModal');
            const editModal = document.getElementById('editReviewModal');
            if (event.target === addModal) {
                closeAddReviewModal();
            }
            if (event.target === editModal) {
                closeEditReviewModal();
            }
        }
    </script>
</body>
</html>
