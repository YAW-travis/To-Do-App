<?php
session_start();
include('connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $otp = trim($_POST['otp']);

    if (empty($email) || empty($otp)) {
        die("Email and OTP required.");
    }

    $stmt = $conn->prepare("SELECT otp FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($stored_otp);
    $stmt->fetch();
    $stmt->close();

    if ($stored_otp === $otp) {
        // OTP correct, remove OTP and mark as verified (optional)
        $update = $conn->prepare("UPDATE users SET otp = NULL WHERE email = ?");
        $update->bind_param("s", $email);
        $update->execute();
        $update->close();

        echo "<script>alert('Verification Successful!'); window.location.href='index.html';</script>";
        exit();
    } else {
        echo "<script>alert('Incorrect OTP!'); window.location.href='verify.html';</script>";
        exit();
    }

    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
