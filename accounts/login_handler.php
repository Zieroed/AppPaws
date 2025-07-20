<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once(__DIR__ . "/../includes/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input = mysqli_real_escape_string($conn, $_POST["email"]);  // This is the email field
    $password = $_POST["password"];

    // Admin shortcut: if input is just 'admin', convert it to full admin email
    if ($input === "admin") {
        $email = "admin@happypaws.com";
    } else {
        $email = $input;
    }

    // Look up user
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($user = mysqli_fetch_assoc($result)) {
        if (password_verify($password, $user['password'])) {
            // Success: start session
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["fname"] = $user["fname"];
            $_SESSION["username"] = $user["username"];
            $_SESSION["lname"] = $user["lname"];
            $_SESSION["role"] = $user["role"];

            // Redirect
            if ($user["role"] === "admin") {
                header("Location: admin/dashboard.php");
            } else {
                header("Location: index.php");
            }
            exit();
        } else {
            $error = "Invalid email or password.";
        }
    } else {
        $error = "Invalid email or password.";
    }
}
?>