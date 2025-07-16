<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once("includes/db.php");

// Redirect if user is not logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: index.php");
    exit();
}
$user_id = $_SESSION["user_id"];

echo "Session user_id: " . ($_SESSION["user_id"] ?? 'Not set');

$sql = "SELECT fname, lname, phone, email, role FROM users WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

if (!$user) {
    echo "<p>User not found in database.</p>";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Welcome - Happy Paws</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include("includes/header.php"); ?>

<div class="container">
    <h1>Welcome, <?php echo htmlspecialchars($user['fname']); ?>!</h1>
    <p><strong>Full Name:</strong> <?php echo htmlspecialchars($user['fname'] . ' ' . $user['lname']); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
    <p><strong>Phone:</strong> <?php echo htmlspecialchars($user['phone']); ?></p>
    <p><strong>Role:</strong> <?php echo htmlspecialchars($user['role']); ?></p>
</div>

<?php include("includes/footer.php"); ?>
</body>
</html>