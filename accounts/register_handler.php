<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once(__DIR__ . "/../includes/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize input
    $fname = mysqli_real_escape_string($conn, $_POST["fname"]);
    $lname = mysqli_real_escape_string($conn, $_POST["lname"]);
    $phone = mysqli_real_escape_string($conn, $_POST["phone"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $password = $_POST["pass"];
    $confirm_pass = $_POST["confirm_pass"];

    // Simple validation
    if ($password !== $confirm_pass) {
        $reg_error = "Passwords do not match.";
        return;
    }

    // Check if email already exists
    $check = "SELECT id FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $check);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    
    if (mysqli_stmt_num_rows($stmt) > 0) {
        $reg_error = "Email already registered.";
        return;
    }

    // Generate username (could be based on first name and last name)
    $username = strtolower($fname); // Example: john.doe
    // Optional: Ensure username is unique
    $username_check = "SELECT id FROM users WHERE username = ?";
    $stmt_check = mysqli_prepare($conn, $username_check);
    mysqli_stmt_bind_param($stmt_check, "s", $username);
    mysqli_stmt_execute($stmt_check);
    mysqli_stmt_store_result($stmt_check);

    // If username already exists, append a number (e.g., john.doe1, john.doe2, etc.)
    $counter = 1;
    while (mysqli_stmt_num_rows($stmt_check) > 0) {
        $username = strtolower($fname . "." . $lname . $counter);
        $counter++;
        mysqli_stmt_execute($stmt_check); // Check the next generated username
    }

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

     // Insert user
    $insert = "INSERT INTO users (fname, lname, phone, email, password, username, role) VALUES (?, ?, ?, ?, ?, ?, 'user')";
    $stmt = mysqli_prepare($conn, $insert);
    mysqli_stmt_bind_param($stmt, "ssssss", $fname, $lname, $phone, $email, $hashed_password, $username);
    
    if (mysqli_stmt_execute($stmt)) {
        // Get the new user ID
        $user_id = mysqli_insert_id($conn);

        // Start session and store user info
        $_SESSION["user_id"] = $user_id;
        $_SESSION["fname"] = $fname;
        $_SESSION["username"] = $username;
        $_SESSION["lname"] = $lname;
        $_SESSION["role"] = "user";
    
        // Redirect to user page
        header("Location: index.php");
        exit();
    } else {
        echo "<p>Registration failed: " . mysqli_error($conn) . "</p>";
    }
}
?>