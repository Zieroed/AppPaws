<?php
session_start();
include_once("includes/db.php");

// Redirect if not logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: index.php");
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = $_SESSION["user_id"];
    $pet_name = mysqli_real_escape_string($conn, $_POST["pet_name"]);
    $pet_type = mysqli_real_escape_string($conn, $_POST["pet_type"]);
    $preferred_date = $_POST["preferred_date"];
    $consultation_type = mysqli_real_escape_string($conn, $_POST["consultation_type"]);
    $message = mysqli_real_escape_string($conn, $_POST["message"]);

    // Insert into appointments
    $sql = "INSERT INTO appointments (user_id, pet_name, pet_type, preferred_date, consultation_type, message, status)
            VALUES (?, ?, ?, ?, ?, ?, 'pending')";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "isssss", $user_id, $pet_name, $pet_type, $preferred_date, $consultation_type, $message);

    if (mysqli_stmt_execute($stmt)) {
        $success = "Appointment scheduled successfully!";
    } else {
        $error = "Failed to schedule appointment.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Schedule Appointment - Happy Paws</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php include("includes/header.php"); ?>

<div class="container">
    <h2>Schedule an Appointment</h2>

    <?php if (isset($success)) echo "<p style='color: green;'>$success</p>"; ?>
    <?php if (isset($error)) echo "<p style='color: red;'>$error</p>"; ?>

    <form action="appointments.php" method="POST" class="form-box">
        <label>Pet Name:</label>
        <input type="text" name="pet_name" required>

        <label>Pet Type:</label>
        <select name="pet_type" required>
            <option value="">Select type</option>
            <option>Dog</option>
            <option>Cat</option>
            <option>Bird</option>
            <option>Rabbit</option>
            <option>Others</option>
        </select>

        <label>Preferred Date:</label>
        <input type="date" name="preferred_date" required>

        <label>Consultation Type:</label>
        <select name="consultation_type" required>
            <option value="">Select type</option>
            <option>Vaccination</option>
            <option>Check-up</option>
            <option>Grooming</option>
            <option>Emergency</option>
        </select>

        <label>Additional Message:</label>
        <textarea name="message" rows="4" placeholder="Write any specific concerns or requests..."></textarea>

        <button type="submit">Book Appointment</button>
    </form>
</div>

<?php include("includes/footer.php"); ?>
</body>
</html>