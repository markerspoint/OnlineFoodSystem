<?php
// Database connection (Assuming $conn is your connection variable)
require_once "db/database.php"; // Update this to your DB connection file

// Handle search query if the search form is submitted
$searchTerm = '';
if (isset($_GET['search'])) {
    $searchTerm = htmlspecialchars($_GET['search']);
    $sql = "SELECT name, description, price, image FROM menuitems WHERE name LIKE ?";
    $stmt = $conn->prepare($sql);
    $searchParam = "%$searchTerm%";
    $stmt->bind_param("s", $searchParam);
} else {
    // Default query without search
    $sql = "SELECT name, description, price, image FROM menuitems";
    $stmt = $conn->prepare($sql);
}

// Execute the query
$stmt->execute();
$result = $stmt->get_result();
?>

<!-- Menu Page with Search Bar and Add to Cart Modal -->
<div class="container py-5">
    <h1 class="text-center mb-4" style="color: #fff;">Our Menu</h1>

    <!-- Search Bar -->
    <div class="row mb-4">
        <div class="col-12 text-center">
            <form method="GET" action="menu.php" class="d-flex justify-content-center">
                <input type="text" name="search" value="<?= $searchTerm ?>" class="form-control w-50"
                    placeholder="Search for food by name...">
                <button type="submit" class="btn btn-danger ms-2">Search</button>
            </form>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="col">
                    <div class="card h-100">
                        <img src="<?= htmlspecialchars($row['image']); ?>" class="card-img-top"
                            alt="<?= htmlspecialchars($row['name']); ?>">
                        <div class="card-body" style="background-color: #292929;">
                            <h5 class="card-title" style="color: #fff;"><?= htmlspecialchars($row['name']); ?></h5>
                            <p class="card-text" style="color: #fff;"><?= htmlspecialchars($row['description']); ?></p>
                            <p class="text-success" style="color: #fff !important;"><strong>Price:
                                    ₱<?= number_format($row['price'], 2); ?></strong></p>
                            <!-- Add to Cart Button -->
                            <button class="btn btn-danger add-to-cart-btn" data-bs-toggle="modal"
                                data-bs-target="#addToCartModal" data-name="<?= htmlspecialchars($row['name']); ?>"
                                data-price="<?= $row['price']; ?>" data-image="<?= htmlspecialchars($row['image']); ?>">Add to
                                Cart</button>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12">
                <p class="text-center">No menu items found.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Add to Cart Modal -->
<div class="modal fade" id="addToCartModal" tabindex="-1" aria-labelledby="addToCartModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addToCartModalLabel">Add Item to Cart</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Do you want to add the item to your cart?</p>
                <div id="itemDetails">
                    <p><strong>Item:</strong> <span id="itemName"></span></p>
                    <p><strong>Price:</strong> ₱<span id="itemPrice"></span></p>
                    <img id="itemImage" src="" alt="Item image" class="img-fluid" style="max-width: 100%; height: auto;">
                </div>

                <!-- Quantity Selector -->
                <div class="d-flex justify-content-between mt-3">
                    <label for="quantity" class="form-label">Quantity:</label>
                    <div class="d-flex align-items-center">
                        <button type="button" class="btn btn-secondary" id="decreaseQty">-</button>
                        <input type="number" id="quantity" class="form-control mx-2" value="1" min="1" style="width: 60px;">
                        <button type="button" class="btn btn-secondary" id="increaseQty">+</button>
                    </div>
                </div>
                
                <div class="d-flex justify-content-between mt-3">
                    <button type="button" class="btn btn-success" id="addToCartBtn">Add to Cart</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">Success!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="successMessage"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

<!-- Inline CSS for styling -->
<style>
    .add-to-cart-btn {
        background-color: #ff4d4d;
        border-color: #ff4d4d;
        color: white;
    }

    .add-to-cart-btn:hover {
        background-color: #e04343;
        border-color: #e04343;
    }

    img {
        width: 250px;
        height: 250px;
    }
</style>

<!-- JavaScript for handling Add to Cart Modal -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
    const addToCartButtons = document.querySelectorAll('.add-to-cart-btn');
    const itemNameElement = document.getElementById('itemName');
    const itemPriceElement = document.getElementById('itemPrice');
    const itemImageElement = document.getElementById('itemImage');
    const quantityInput = document.getElementById('quantity');
    const addToCartBtn = document.getElementById('addToCartBtn');
    const decreaseQtyButton = document.getElementById('decreaseQty');
    const increaseQtyButton = document.getElementById('increaseQty');
    
    const successModal = new bootstrap.Modal(document.getElementById('successModal'));
    const successMessageElement = document.getElementById('successMessage');
    
    // Success modal - OK button to close both modals
    const successOkButton = document.querySelector('#successModal .btn-primary');
    const addToCartModal = new bootstrap.Modal(document.getElementById('addToCartModal'));

    // Add event listener to "OK" button of the success modal
    successOkButton.addEventListener('click', function () {
        // Close both modals
        addToCartModal.hide();
        successModal.hide();
    });

    addToCartButtons.forEach(button => {
        button.addEventListener('click', function () {
            const itemName = this.getAttribute('data-name');
            const itemPrice = this.getAttribute('data-price');
            const itemImage = this.getAttribute('data-image');

            itemNameElement.textContent = itemName;
            itemPriceElement.textContent = itemPrice;
            itemImageElement.src = itemImage;

            // Reset quantity to 1 each time a new item is added to cart
            quantityInput.value = 1;

            // Handle quantity increase and decrease
            increaseQtyButton.addEventListener('click', function () {
                quantityInput.value = parseInt(quantityInput.value) + 1;
            });

            decreaseQtyButton.addEventListener('click', function () {
                if (parseInt(quantityInput.value) > 1) {
                    quantityInput.value = parseInt(quantityInput.value) - 1;
                }
            });

            // Handle the 'Add to Cart' action
            addToCartBtn.onclick = function () {
                const quantity = quantityInput.value;
                const message = `${quantity} ${itemName}(s) have been added to your cart!`;

                // Show the success message modal
                successMessageElement.textContent = message;
                successModal.show();

                // Close the add to cart modal
                addToCartModal.hide();
            };
        });
    });
});

</script>
