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
$sql = "SELECT id, fname, lname, email, role FROM users ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - Happy Paws</title>
    <link rel="stylesheet" href="/AppPaws/css/style.css">
</head>
<body>
<?php include_once(__DIR__ . "/../includes/header.php"); ?>

<div class="container">
    <h1>Welcome, Admin <?php echo htmlspecialchars($_SESSION["fname"]); ?>!</h1>
    <h2>Registered Users</h2>

    <table border="1" cellpadding="10" cellspacing="0">
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
</div>

<?php include_once(__DIR__ . "/../includes/footer.php"); ?>
</body>
</html>