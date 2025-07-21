<?php
session_start();
include_once("includes/db.php");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['appointment_id'], $_POST['action'])) {
    $appointment_id = intval($_POST['appointment_id']);
    $action = $_POST['action'];

    if ($action === 'approve') {
        $status = 'Approved';
    } elseif ($action === 'decline') {
        $status = 'Declined';
    } else {
        $status = 'Pending';
    }

    $sql = "UPDATE appointments SET status = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "si", $status, $appointment_id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: admin/dashboard.php");
        exit();
    } else {
        echo "Error updating appointment: " . mysqli_error($conn);
    }
}
?>