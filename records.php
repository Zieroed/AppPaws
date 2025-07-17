<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once("includes/db.php");
include("includes/header.php");
$mysqli = new mysqli("localhost", "root", "", "happy_paws");

$filter = isset($_GET['pet_id']) ? (int)$_GET['pet_id'] : null;

$query = "SELECT * FROM records";
if ($filter) {
    $query .= " WHERE pet_id = $filter";
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
    <script>
        function toggleDetails(el) {
        const detailsRow = el.closest('tr').nextElementSibling;
        const detailsDiv = detailsRow.querySelector('.details');
        const isVisible = detailsDiv.style.display === 'block';

        detailsDiv.style.display = isVisible ? 'none' : 'block';
        el.innerHTML = isVisible ? '&#x25BC;' : '&#x25B2;'; // down / up arrow
    }
    </script>
</body>
</html>