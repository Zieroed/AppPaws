<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once("includes/db.php");
include("includes/header.php");
$mysqli = new mysqli("localhost", "root", "", "happy_paws");

$filter = isset($_GET['pet_id']) && $_GET['pet_id'] !== '' ? (int)$_GET['pet_id'] : null;

$user_id = $_SESSION['user_id']; // assuming this is set at login
$role = $_SESSION['role'];       // assuming this is set at login

$query = "
    SELECT 
        records.*, 
        pets.name AS pet_name, 
        CONCAT(users.fname, ' ', users.lname) AS owner_name 
    FROM records
    JOIN pets ON records.pet_id = pets.id
    JOIN users ON records.user_id = users.id
";

if ($role !== 'admin') {
    $query .= " WHERE records.user_id = $user_id";
    if ($filter) {
        $query .= " AND records.pet_id = $filter";
    }
} else {
    if ($filter) {
        $query .= " WHERE records.pet_id = $filter";
    }
}

$result = $mysqli->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pet Records</title>
    <link id="stylesheet" rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="page-wrapper">
        <main class="container">
            <h2>Pet Medical Records</h2>
            <form class="filter-form" method="GET" action="">
                <div class="filter-buttons">
                    <input type="number" name="pet_id" placeholder="Filter by Pet ID" value="<?= htmlspecialchars($filter) ?>">
                    <button type="submit" class="filter-btn">Filter</button>
                    <?php if ($filter): ?>
                        <a href="records.php" class="filter-btn reset-btn">Reset</a>
                    <?php endif; ?>
                </div>
            </form>

            <?php if ($result && $result->num_rows > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Pet ID</th>
                            <th>Owner Name</th>
                            <th>Pet Name</th>
                            <th>Service</th>
                            <th>Veterinarian in Charge</th>
                            <th>Date</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['pet_id']) ?></td>
                                <td><?= htmlspecialchars($row['owner_name']) ?></td>
                                <td><?= htmlspecialchars($row['pet_name']) ?></td>
                                <td><?= htmlspecialchars($row['service']) ?></td>
                                <td><?= htmlspecialchars($row['vet_in_charge']) ?></td>
                                <td><?= htmlspecialchars($row['visit_date']) ?></td>
                                <td class="toggle-arrow" onclick="toggleDetails(this)">&#x25BC;</td>
                            </tr>
                            <tr class="details-row">
                                <td colspan="5">
                                    <div class="details"><?= html_entity_decode($row['detailed_report']) ?></div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No records found.</p>
            <?php endif; ?>
        </main>
    </div>
    <?php include_once("includes/footer.php"); ?>
    <script src="js/records.js"></script>
</body>
</html>