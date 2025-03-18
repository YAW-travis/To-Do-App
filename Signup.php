<?php
session_start();
include('connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirmpass = trim($_POST['confirmpass']);

    // Validation
    if (empty($username) || empty($email) || empty($password) || empty($confirmpass)) {
        die("All fields are required.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format.");
    }

    if ($password !== $confirmpass) {
        die("Passwords do not match.");
    }

    $email = mysqli_real_escape_string($conn, $email);
    $username = mysqli_real_escape_string($conn, $username);
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check existing email
    $stmt = $conn->prepare("SELECT email FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        die("Email already registered.");
    }
    $stmt->close();

    // Generate 4-digit OTP
    $otp = rand(1000, 9999);

    // Insert user
    $stmt = $conn->prepare("INSERT INTO users (username, email, password, otp) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $email, $hashed_password, $otp);

    if ($stmt->execute()) {
        $_SESSION['email'] = $email;
        $_SESSION['otp'] = $otp; // Save OTP in session
        echo "<script>alert('Your OTP is: $otp'); window.location.href='verify.html';</script>";
        exit();
    } else {
        die("Could not sign up: " . $stmt->error);
    }

    $stmt->close();
    $conn->close();
} else {
    die("Invalid request method.");
}
?>
