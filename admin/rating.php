<?php
include '../db/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['delete_id'])) {
        // Delete functionality
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

    if (isset($_POST['edit_id'])) {
        // Edit functionality
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
}

$sql = "SELECT * FROM reviews";
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
        .delete-btn, .edit-btn { color: white; border: none; padding: 5px 10px; border-radius: 5px; cursor: pointer; }
        .delete-btn { background-color: #ff4d4d; }
        .delete-btn:hover { background-color: #d73838; }
        .edit-btn { background-color: #4caf50; }
        .edit-btn:hover { background-color: #3e8e41; }
        .modal { display: none; position: fixed; z-index: 1; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0, 0, 0, 0.5); }
        .modal-content { background-color: #fff; margin: 15% auto; padding: 20px; border: 1px solid #888; width: 50%; border-radius: 8px; }
        .modal-close { float: right; color: #aaa; font-size: 28px; font-weight: bold; cursor: pointer; }
        .modal-close:hover, .modal-close:focus { color: black; text-decoration: none; cursor: pointer; }
        .save-btn { background-color: #6c63ff; color: white; border: none; padding: 10px 15px; border-radius: 5px; cursor: pointer; }
        .save-btn:hover { background-color: #5348c4; }
    </style>
</head>
<body>
    <div class="container">
        <a href="indexdashboard.php" style="display: inline-block; margin-bottom: 20px; text-decoration: none; background-color: #6c63ff; color: white; padding: 10px 15px; border-radius: 5px;">Back</a>
        <h2>Ratings and Reviews</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User ID</th>
                    <th>Menu Item ID</th>
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
                            <td><?= $row['user_id'] ?></td>
                            <td><?= $row['menu_item_id'] ?></td>
                            <td><?= $row['rating'] ?></td>
                            <td><?= htmlspecialchars($row['comment']) ?></td>
                            <td><?= $row['created_at'] ?></td>
                            <td>
                                <form method="POST" style="display: inline;">
                                    <input type="hidden" name="delete_id" value="<?= $row['id'] ?>">
                                    <button type="submit" class="delete-btn">Delete</button>
                                </form>
                                <button class="edit-btn" onclick="openModal(<?= $row['id'] ?>, '<?= htmlspecialchars($row['comment']) ?>')">Edit</button>
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

    <!-- Edit Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="modal-close" onclick="closeModal()">&times;</span>
            <h2>Edit Comment</h2>
            <form method="POST">
                <input type="hidden" id="edit_id" name="edit_id">
                <label for="comment">Comment:</label>
                <textarea id="comment" name="comment" rows="4" style="width: 100%; padding: 10px; margin-top: 10px; border: 1px solid #ddd; border-radius: 5px;"></textarea>
                <button type="submit" class="save-btn">Save</button>
            </form>
        </div>
    </div>

    <script>
        function openModal(id, comment) {
            document.getElementById('editModal').style.display = 'block';
            document.getElementById('edit_id').value = id;
            document.getElementById('comment').value = comment;
        }

        function closeModal() {
            document.getElementById('editModal').style.display = 'none';
        }

        // Close modal when clicking outside of it
        window.onclick = function(event) {
            const modal = document.getElementById('editModal');
            if (event.target === modal) {
                closeModal();
            }
        }
    </script>
</body>
</html>
