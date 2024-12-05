<?php
// Start output buffering at the very beginning
ob_start();

// Start session before any output
session_start();

// Include database connection
include 'db/database.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if already logged in
if (isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}

// Initialize error message variable
$error_message = '';

// Handle form submission
if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    
    // Use prepared statements to prevent SQL injection
    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $query);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if ($result && mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            
            if (password_verify($_POST['password'], $user['password'])) {
                // Set session variables to match your database columns
                $_SESSION['id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $user['email'];
                
                // Clear all output buffers
                ob_end_clean();
                
                // Redirect with absolute path
                header("Location: index.php"); // Adjust the path based on your folder structure
                exit();
            } else {
                $error_message = "Incorrect password!";
            }
        } else {
            $error_message = "User not found!";
        }
        mysqli_stmt_close($stmt);
    }
}

// Store error message in session if exists
if (!empty($error_message)) {
    $_SESSION['error_message'] = $error_message;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* Your existing styles */
        body {
            background-color: #121212;
            color: #fff;
            font-family: Arial, sans-serif;
        }

        .form-container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            border-radius: 10px;
            background-color: #1e1e1e;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .nav-pills .nav-link {
            border-radius: 5px;
        }

        .nav-pills .nav-link.active {
            background-color: #007bff;
            color: #fff;
        }

        .social-icons a {
            color: #fff;
            margin: 0 10px;
            font-size: 1.5rem;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .form-check-label {
            color: #bbb;
        }
    </style>
    <title>Login</title>
</head>
<body>
<div class="form-container">
    <h2 class="text-center mb-4">Login</h2>
    <?php
    // Display error message if exists
    if (isset($_SESSION['error_message'])) {
        echo '<div class="alert alert-danger">' . htmlspecialchars($_SESSION['error_message']) . '</div>';
        unset($_SESSION['error_message']); // Clear the error message
    }
    ?>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
        <div class="text-center mb-3">
            <p>Sign in with:</p>
            <div class="social-icons">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-google"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-github"></i></a>
            </div>
        </div>
        <p class="text-center">or:</p>
        <div class="form-outline mb-3">
            <input type="text" name="username" id="loginUsername" class="form-control" placeholder="Enter Username" required />
            <label class="form-label" for="loginUsername"></label>
        </div>
        <div class="form-outline mb-3">
            <input type="password" name="password" id="loginPassword" class="form-control" placeholder="Enter Password" required />
            <label class="form-label" for="loginPassword"></label>
        </div>
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" value="" id="rememberMe" />
            <label class="form-check-label" for="rememberMe">Remember me</label>
        </div>
        <button type="submit" name="login" class="btn btn-primary btn-block w-100">Sign In</button>
    </form>
    <p class="text-center mt-3">Don't have an account? <a href="register.php" class="text-decoration-none">Register here</a></p>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
// Flush output buffer at the end
ob_end_flush();
?>