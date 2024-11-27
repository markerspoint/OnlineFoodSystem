<?php
include 'db/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data (no name field in the table)
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // Check if the passwords match
    if ($password === $confirmPassword) {
        // Hash the password for security
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert user data into the database (without name column)
        $query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashedPassword')";
        
        if (mysqli_query($conn, $query)) {
            // Redirect to login page upon successful registration
            header("Location: login.php");
            exit();
        } else {
            // If there's an error inserting data
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "Passwords do not match!";
    }
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
            background-color: #ff9900;
        }

        .form-check-label {
            color: #bbb;
        }
    </style>
      <title>Register</title>
</head>
<body>
<div class="form-container">
    <h2 class="text-center mb-4">Register</h2>
    <form action="register.php" method="POST">
        <div class="text-center mb-3">
            <p>Sign up with:</p>
            <div class="social-icons">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-google"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-github"></i></a>
            </div>
        </div>
        <p class="text-center">or:</p>
        <div class="form-outline mb-3">
            <input type="text" name="username" id="registerUsername" class="form-control" required />
            <label class="form-label" for="registerUsername">Username</label>
        </div>
        <div class="form-outline mb-3">
            <input type="email" name="email" id="registerEmail" class="form-control" required />
            <label class="form-label" for="registerEmail">Email</label>
        </div>
        <div class="form-outline mb-3">
            <input type="password" name="password" id="registerPassword" class="form-control" required />
            <label class="form-label" for="registerPassword">Password</label>
        </div>
        <div class="form-outline mb-3">
            <input type="password" name="confirmPassword" id="registerConfirmPassword" class="form-control" required />
            <label class="form-label" for="registerConfirmPassword">Repeat password</label>
        </div>
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" value="" id="termsAgreement" required />
            <label class="form-check-label" for="termsAgreement">I have read and agree to the terms</label>
        </div>
        <button type="submit" name="register" class="btn btn-primary btn-block w-100">Sign Up</button>
    </form>
    <p class="text-center mt-3">Already have an account? <a href="login.php" class="text-decoration-none">Login here</a></p>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>