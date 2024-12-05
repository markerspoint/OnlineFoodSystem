<?php include "nav/header.php"; ?>

<?php
$userId = $_SESSION['id'];
$message = '';

// Handle form submission for updating user info
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $username = htmlspecialchars(trim($_POST['username']));
    $email = htmlspecialchars(trim($_POST['email']));
    $fullname = htmlspecialchars(trim($_POST['fullname'] ?? ''));
    $address = htmlspecialchars(trim($_POST['address'] ?? ''));
    $phone = htmlspecialchars(trim($_POST['phone'] ?? ''));
    
    // Update query with additional fields
    $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, fullname = ?, address = ?, phone = ? WHERE id = ?");
    $stmt->bind_param("sssssi", $username, $email, $fullname, $address, $phone, $userId);
    if ($stmt->execute()) {
        $_SESSION['username'] = $username;
        $message = 'Profile updated successfully.';
    } else {
        $message = 'Failed to update profile.';
    }
}

// Fetch current user data
$stmt = $conn->prepare("SELECT username, email, fullname, address, phone, created_at FROM users WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<section class="profile-section">
  <div class="container py-5">
    <h2 class="mb-4 text-center">My Profile</h2>

    <?php if ($message): ?>
      <div class="alert alert-success"><?= $message ?></div>
    <?php endif; ?>

    <div class="profile-container bg-dark p-4 rounded">
      <div class="profile-sidebar bg-danger text-white text-center p-4 rounded-start">
        <div class="profile-avatar">
          <img src="cImage/user-solid.svg" alt="Profile Picture" class="rounded-circle mb-3">
        </div>
        <h4><?= htmlspecialchars($user['username']) ?></h4>
      </div>
      <div class="profile-content p-4 rounded-end">
        <div id="profileDetails" class="mb-4">
          <p><strong>Username:</strong> <?= htmlspecialchars($user['username']) ?></p>
          <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
          
          <?php if (!empty($user['fullname'])): ?>
            <p><strong>Full Name:</strong> <?= htmlspecialchars($user['fullname']) ?></p>
          <?php endif; ?>
          
          <?php if (!empty($user['address'])): ?>
            <p><strong>Address:</strong> <?= htmlspecialchars($user['address']) ?></p>
          <?php endif; ?>
          
          <?php if (!empty($user['phone'])): ?>
            <p><strong>Phone:</strong> <?= htmlspecialchars($user['phone']) ?></p>
          <?php endif; ?>
          
          <p><strong>Account Created:</strong> <?= $user['created_at'] ?></p>
          <button id="editProfileBtn" class="btn btn-warning">Edit Profile</button>
          <!-- Delete account button -->
          <button id="deleteAccountBtn" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">Delete Account</button>
        </div>

        <form id="editProfileForm" method="POST" class="d-none">
          <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" id="username" name="username" class="form-control" value="<?= htmlspecialchars($user['username']) ?>" required>
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" required>
          </div>
          <div class="mb-3">
            <label for="fullname" class="form-label">Full Name</label>
            <input type="text" id="fullname" name="fullname" class="form-control" value="<?= htmlspecialchars($user['fullname'] ?? '') ?>">
          </div>
          <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <input type="text" id="address" name="address" class="form-control" value="<?= htmlspecialchars($user['address'] ?? '') ?>">
          </div>
          <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="tel" id="phone" name="phone" class="form-control" value="<?= htmlspecialchars($user['phone'] ?? '') ?>">
          </div>
          <div class="mb-3">
            <label for="created_at" class="form-label">Account Created</label>
            <input type="text" id="created_at" class="form-control" value="<?= $user['created_at'] ?>" readonly>
          </div>
          <div class="d-flex justify-content-between">
            <button type="submit" name="update" class="btn btn-success">Update Profile</button>
            <button type="button" id="cancelEditBtn" class="btn btn-danger">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>

<!-- Modal for confirming delete -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteAccountModalLabel" style="color: black;">Confirm Account Deletion</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="deleteAccountForm" method="POST">
          <div class="mb-3">
            <!-- <label for="password" class="form-label" style="color: black;"></label> --> 
            <input type="password" id="password" name="password" class="form-control" style="background-color: #fff" placeholder="Enter password" required>
          </div>
          <div class="d-flex justify-content-between">
            <button type="submit" name="delete" class="btn btn-danger">Delete Account</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const profileDetails = document.getElementById('profileDetails');
    const editProfileForm = document.getElementById('editProfileForm');
    const editProfileBtn = document.getElementById('editProfileBtn');
    const cancelEditBtn = document.getElementById('cancelEditBtn');
    const deleteAccountForm = document.getElementById('deleteAccountForm');

    editProfileBtn.addEventListener('click', () => {
      profileDetails.classList.add('d-none');
      editProfileForm.classList.remove('d-none');
    });

    cancelEditBtn.addEventListener('click', () => {
      editProfileForm.classList.add('d-none');
      profileDetails.classList.remove('d-none');
    });

    deleteAccountForm.addEventListener('submit', (e) => {
      e.preventDefault();

      const password = document.getElementById('password').value;

      // Perform password check via AJAX or PHP request
      const xhr = new XMLHttpRequest();
      xhr.open('POST', 'delete_account.php', true);
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      xhr.onload = function() {
        if (xhr.status === 200) {
          const response = JSON.parse(xhr.responseText);
          if (response.success) {
            alert("Account deleted successfully.");
            window.location.href = 'logout.php';  // Redirect to logout page
          } else {
            alert("Incorrect password. Please try again.");
          }
        }
      };
      xhr.send('password=' + encodeURIComponent(password));
    });
  });
</script>

<style>
  .profile-section {
    margin: 0 auto;
    max-width: 800px;
  }

  .profile-container {
    display: flex;
    background-color: #121212;
    border-radius: 8px;
    overflow: hidden;
  }

  .profile-sidebar {
    background-color: #ff4d4d;
    text-align: center;
    padding: 30px;
    border-radius: 8px 0 0 8px;
  }

  .profile-content {
    flex: 1;
    background-color: #1e1e1e;
    padding: 30px;
    border-radius: 0 8px 8px 0;
  }

  .profile-section h2 {
    color: #ff4d4d;
  }

  .form-control {
    background-color: #2d2d2d;
    color: #fff;
    border: 1px solid #444;
  }

  .btn-success, .btn-danger, .btn-warning {
    width: 48%;
  }
</style>

<?php include "nav/footer.php"; ?>
