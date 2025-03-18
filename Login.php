<?php
include('connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        // You can use a session or redirect with error message
        header("Location: index.html?error=empty_fields");
        exit();
    }

    $email = mysqli_real_escape_string($conn, $email);

    $stmt = $conn->prepare("SELECT password FROM users WHERE email = ?");

    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($hashed_password);
            $stmt->fetch();

            if (password_verify($password, $hashed_password)) {
                // Successful login
                header("Location: Todo.html");
                exit();
            } else {
                header("Location: index.html?error=invalid_credentials");
                exit();
            }
        } else {
            header("Location: index.html?error=invalid_credentials");
            exit();
        }

        $stmt->close();
    } else {
        echo "Error in preparing statement: " . $conn->error;
    }

    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
