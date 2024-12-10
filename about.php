<?php
include 'db/database.php';

// Fetch menu items for the dropdown
$menuitems_query = "SELECT id, name FROM menuitems";
$menuitems_result = $conn->query($menuitems_query);
?>

<!-- REVIEWS -->
<section id="review" style="background-color: #2e2d2d; padding: 50px 0;">
    <div class="container" style="max-width: 1200px; margin: 0 auto;">
        <div class="text-center" style="margin-bottom: 30px;">
            <h2 style="font-size: 2.5rem; font-weight: bold; color: #fff;">REVIEWS</h2>
            <p style="font-size: 1.1rem; color: #ccc; margin-top: 10px;">
                Bringing the taste of home to your doorstep – where quality and convenience meet!
            </p>
            <!-- "Click Here to Review" Button -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#reviewModal">
                Click Here to Review
            </button>
        </div>
        <!-- Items -->
        <div class="row row-cols-lg-3">
            <?php
            // Fetch reviews from the database
            $reviews_query = "SELECT r.id, r.rating, r.comment, m.name AS menu_item_name 
                              FROM reviews r 
                              JOIN menuitems m ON r.menu_item_id = m.id";
            $reviews_result = $conn->query($reviews_query);
            if ($reviews_result->num_rows > 0) {
                while ($row = $reviews_result->fetch_assoc()) {
                    ?>
                    <div class="col">
                        <div class="testimonials mt-4" data-id="<?php echo $row['id']; ?>" 
                             style="border: 1px solid #444; border-radius: 10px; padding: 20px; background-color: #fff; transition: transform 0.3s, box-shadow 0.3s;">
                            <div class="d-flex align-items-center">
                                <img src="cImage/user-solid.svg" alt="" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
                                <div class="ms-2 mb-2">
                                    <h3 style="font-size: 1.2rem; margin: 0; color: #333;"><?php echo $row['menu_item_name']; ?></h3>
                                    <a href="#" class="text-decoration-none" style="font-size: 0.9rem; color: #007bff;">Rating: <?php echo $row['rating']; ?></a>
                                </div>
                            </div>
                            <p style="margin-top: 10px; font-size: 1rem; color: #555;"><?php echo $row['comment']; ?></p>
                            <!-- Edit Button -->
                            <button class="btn btn-sm btn-secondary edit-review" data-id="<?php echo $row['id']; ?>" data-bs-toggle="modal" data-bs-target="#reviewModal">Edit</button>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>
</section>

<!-- Review Modal -->
<div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="submit_review.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="reviewModalLabel">Submit Review</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="review_id" id="review_id" value="">
                    <!-- Dropdown for Menu Items -->
                    <div class="mb-3">
                        <label for="menu_item_id" class="form-label">Menu Item</label>
                        <select class="form-select" name="menu_item_id" id="menu_item_id" required>
                            <option value="">Select Menu Item</option>
                            <?php
                            if ($menuitems_result->num_rows > 0) {
                                while ($item = $menuitems_result->fetch_assoc()) {
                                    echo '<option value="' . $item['id'] . '">' . $item['name'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <!-- Rating -->
                    <div class="mb-3">
                        <label for="rating" class="form-label">Rating (1-5)</label>
                        <input type="number" class="form-control" name="rating" id="rating" min="1" max="5" required>
                    </div>
                    <!-- Comment -->
                    <div class="mb-3">
                        <label for="comment" class="form-label">Comment</label>
                        <textarea class="form-control" name="comment" id="comment" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
    const testimonials = document.querySelectorAll('.testimonials');
    const editButtons = document.querySelectorAll('.edit-review');
    const modal = document.getElementById('reviewModal');
    const reviewIdInput = document.getElementById('review_id');
    const menuItemIdInput = document.getElementById('menu_item_id');
    const ratingInput = document.getElementById('rating');
    const commentInput = document.getElementById('comment');

    // Edit button click event
    editButtons.forEach(button => {
        button.addEventListener('click', function () {
            const reviewId = this.getAttribute('data-id');
            fetch(`get_review.php?id=${reviewId}`)
                .then(response => response.json())
                .then(data => {
                    reviewIdInput.value = data.id; // Set review ID for editing
                    menuItemIdInput.value = data.menu_item_id; // Set the menu item
                    ratingInput.value = data.rating; // Set rating
                    commentInput.value = data.comment; // Set comment
                });
        });
    });

    // Form submission (update or add review)
    const form = document.querySelector('form');
    form.addEventListener('submit', function (event) {
        event.preventDefault(); // Prevent default form submission

        const formData = new FormData(form);
        fetch(form.action, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            console.log(data); // Add this to see exactly what's being returned

            if (data.success) {
                // Update review content in the testimonials section
                const reviewCard = document.querySelector(`.testimonials[data-id="${data.id}"]`);
                if (reviewCard) {
                    // Update rating
                    const ratingElement = reviewCard.querySelector('a');
                    if (ratingElement) {
                        ratingElement.textContent = `Rating: ${data.rating}`;
                    }

                    // Update comment
                    const commentElement = reviewCard.querySelector('p');
                    if (commentElement) {
                        commentElement.textContent = data.comment;
                    }

                    // Close the modal
                    const modalInstance = bootstrap.Modal.getInstance(modal);
                    if (modalInstance) {
                        modalInstance.hide();
                    }

                    // Show success alert
                    alert('Review updated successfully!');
                }
            } else {
                // Show error message
                alert('Failed to update review');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while updating the review');
        });
    });
});



</script>
