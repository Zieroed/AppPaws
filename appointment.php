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

    // Insert pet if not already in pets table for this user
    $pet_check_sql = "SELECT id FROM pets WHERE user_id = ? AND name = ? AND type = ?";
    $pet_check_stmt = mysqli_prepare($conn, $pet_check_sql);
    mysqli_stmt_bind_param($pet_check_stmt, "iss", $user_id, $pet_name, $pet_type);
    mysqli_stmt_execute($pet_check_stmt);
    mysqli_stmt_store_result($pet_check_stmt);
    if (mysqli_stmt_num_rows($pet_check_stmt) == 0) {
        $pet_insert_sql = "INSERT INTO pets (user_id, name, type) VALUES (?, ?, ?)";
        $pet_insert_stmt = mysqli_prepare($conn, $pet_insert_sql);
        mysqli_stmt_bind_param($pet_insert_stmt, "iss", $user_id, $pet_name, $pet_type);
        mysqli_stmt_execute($pet_insert_stmt);
        mysqli_stmt_close($pet_insert_stmt);
    }
    mysqli_stmt_close($pet_check_stmt);

    // Insert into appointments
    $today = date("Y-m-d");
    if ($preferred_date < $today) {
        $error = "You cannot book for a past date.";
    } else {
        $check_sql = "SELECT COUNT(*) as count FROM appointments WHERE preferred_date = ?";
        $check_stmt = mysqli_prepare($conn, $check_sql);
        mysqli_stmt_bind_param($check_stmt, "s", $preferred_date);
        mysqli_stmt_execute($check_stmt);
        mysqli_stmt_bind_result($check_stmt, $count);
        mysqli_stmt_fetch($check_stmt);
        mysqli_stmt_close($check_stmt);

        if ($count >= 5) {
            $error = "This date is fully booked. Please choose another.";
        } else {
            // Insert into appointments
            $sql = "INSERT INTO appointments (user_id, pet_name, pet_type, preferred_date, consultation_type, message, status)
                    VALUES (?, ?, ?, ?, ?, ?, 'Pending')";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "isssss", $user_id, $pet_name, $pet_type, $preferred_date, $consultation_type, $message);

            if (mysqli_stmt_execute($stmt)) {
                $success = "Appointment scheduled successfully!";
            } else {
                $error = "Failed to schedule appointment.";
            }
        }
    }
}

// Fetch booked dates with more than 3 appointments
$booked_dates = [];
$sql = "SELECT preferred_date, COUNT(*) as total FROM appointments GROUP BY preferred_date HAVING total >= 3";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    $booked_dates[] = $row["preferred_date"];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Schedule Appointment - Happy Paws</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        #main-footer {
            position: fixed;
            bottom: 0px;
            width: 100%;
            background-color: #f8f9fa;
            padding: 20px 0;
            text-align: center;
        }
    </style>
</head>
<body>
<?php include("includes/header.php"); ?>
<div class="appt-split-layout">
    <div class="appt-left">
        <h2 class="appointment-title">Schedule an Appointment</h2>
        <p class="appt-desc">Feathers, fur, or little feet, we make every visit a treat.<br>
        Let's keep your pet pals happy, healthy, and complete!</p>
    </div>
    <div class="appt-right">
        <?php if (isset($success)) echo "<p style='color: green;'>$success</p>"; ?>
        <?php if (isset($error)) echo "<p style='color: red;'>$error</p>"; ?>
        <form action="appointment.php" method="POST" class="appointment-form-circle appointment-form-wide">
            <input type="text" name="pet_name" placeholder="Pet Name" required>
            <select name="pet_type" required>
                <option value="">Pet Type</option>
                <option>Dog</option>
                <option>Cat</option>
                <option>Bird</option>
                <option>Rabbit</option>
                <option>Others</option>
            </select>
            <input type="date" name="preferred_date" required>
            <select name="consultation_type" required>
                <option value="">Consultation Type</option>
                <option>Vaccination</option>
                <option>Check-up</option>
                <option>Grooming</option>
                <option>Emergency</option>
            </select>
            <textarea name="message" rows="4" placeholder="Write any specific concerns or requests..."></textarea>
            <input class="submit" type="submit" value="Book Appointment">
        </form>
    </div>
    <?php include("includes/footer.php"); ?>
</div>
<script>
    const disabledDates = <?php echo json_encode($booked_dates); ?>;
    document.addEventListener("DOMContentLoaded", function () {
        const dateInput = document.querySelector('input[name="preferred_date"]');
        const today = new Date().toISOString().split('T')[0];
        dateInput.min = today;

        dateInput.addEventListener("input", function () {
            if (disabledDates.includes(this.value)) {
                alert("This date is already fully booked. Please select another date.");
                this.value = "";
            }
        });
    });
</script>
</body>
</html>