<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once(__DIR__ . "/../includes/db.php");

// Redirect if not logged in or not admin
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== 'admin') {
    header("Location: /AppPaws/index.php");
    exit();
}

// Fetch all users
$sql = "SELECT id, fname, lname, email, role FROM users ORDER BY id ASC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - Happy Paws</title>
    <link rel="stylesheet" href="/AppPaws/css/style.css">
    <link rel="stylesheet" href="/AppPaws/css/dashboard.css">
</head>
<body>
<?php include_once(__DIR__ . "/../includes/header.php"); ?>
<div class="page-wrapper">
    <main>
        <div class="container">
            <h1>Admin Dashboard</h1>

            <h2 style="margin-top:40px;">Registered Appointments</h2>
            <table border="1" cellpadding="10" cellspacing="0" style="width:92%; margin:auto;">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Owner</th>
                        <th>Pet Name</th>
                        <th>Pet Type</th>
                        <th>Date</th>
                        <th>Consultation</th>
                        <th>Message</th>
                        <th>Status</th>
                        <th>Approval</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $appt_sql = "SELECT a.*, u.fname, u.lname FROM appointments a JOIN users u ON a.user_id = u.id ORDER BY a.preferred_date DESC";
                    $appt_result = mysqli_query($conn, $appt_sql);
                    while ($appt = mysqli_fetch_assoc($appt_result)) {
                        echo "<tr>";
                        echo "<td>" . $appt['id'] . "</td>";
                        echo "<td>" . htmlspecialchars($appt['fname'] . ' ' . $appt['lname']) . "</td>";
                        echo "<td>" . htmlspecialchars($appt['pet_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($appt['pet_type']) . "</td>";
                        echo "<td>" . htmlspecialchars($appt['preferred_date']) . "</td>";
                        echo "<td>" . htmlspecialchars($appt['consultation_type']) . "</td>";
                        echo "<td>" . htmlspecialchars($appt['message']) . "</td>";
                        echo "<td>" . htmlspecialchars($appt['status']) . "</td>";

                        echo "<td>";
                        echo "<form method='post' action='/AppPaws/approve_appointment.php' style='display:inline;'>";
                        echo "<input type='hidden' name='appointment_id' value='" . $appt['id'] . "'>";
                        echo "<input type='hidden' name='action' value='approve'>";
                        echo "<button type='submit' class='btn-approve' title='Approve'>&#10004;</button>";
                        echo "</form>";

                        echo "<form method='post' action='/AppPaws/approve_appointment.php' style='display:inline; margin-left:5px;'>";
                        echo "<input type='hidden' name='appointment_id' value='" . $appt['id'] . "'>";
                        echo "<input type='hidden' name='action' value='decline'>";
                        echo "<button type='submit' class='btn-decline' title='Decline'>&#10008;</button>";
                        echo "</form>";
                        echo "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>

            <h2>Registered Users</h2>
            <table border="1" cellpadding="10" cellspacing="0" style="width:92%; margin:auto;">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Role</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo $row["id"]; ?></td>
                            <td><?php echo htmlspecialchars($row["fname"] . " " . $row["lname"]); ?></td>
                            <td><?php echo htmlspecialchars($row["email"]); ?></td>
                            <td><?php echo htmlspecialchars($row["role"]); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <h2 style="margin-top:40px;">Registered Pets</h2>
            <table border="1" cellpadding="10" cellspacing="0" style="width:92%; margin:auto;">
                <thead>
                    <tr>
                        <th>Pet ID</th>
                        <th>User</th>
                        <th>Pet Name</th>
                        <th>Pet Type</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $pet_sql = "SELECT p.id, p.name, p.type, u.fname, u.lname FROM pets p JOIN users u ON p.user_id = u.id ORDER BY p.id ASC";
                    $pet_result = mysqli_query($conn, $pet_sql);
                    while ($pet = mysqli_fetch_assoc($pet_result)) {
                        echo "<tr>";
                        echo "<td>" . $pet['id'] . "</td>";
                        echo "<td>" . htmlspecialchars($pet['fname'] . ' ' . $pet['lname']) . "</td>";
                        echo "<td>" . htmlspecialchars($pet['name']) . "</td>";
                        echo "<td>" . htmlspecialchars($pet['type']) . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <?php include_once(__DIR__ . "/../includes/footer.php"); ?>
    </main>
</div>
</body>
</html>