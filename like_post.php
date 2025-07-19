<?php
session_start();
include("includes/db.php");

if (!isset($_SESSION['user_id']) || !isset($_POST['post_id'])) {
    echo json_encode(["success" => false]);
    exit;
}

$user_id = $_SESSION['user_id'];
$post_id = $_POST['post_id'];

// Check if already liked
$check = $conn->prepare("SELECT id FROM likes WHERE user_id = ? AND post_id = ?");
$check->bind_param("ii", $user_id, $post_id);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    // Unlike (DELETE)
    $delete = $conn->prepare("DELETE FROM likes WHERE user_id = ? AND post_id = ?");
    $delete->bind_param("ii", $user_id, $post_id);
    $delete->execute();
    $liked = false;
} else {
    // Like (INSERT)
    $insert = $conn->prepare("INSERT INTO likes (user_id, post_id) VALUES (?, ?)");
    $insert->bind_param("ii", $user_id, $post_id);
    $insert->execute();
    $liked = true;
}

// Get new like count
$result = $conn->prepare("SELECT COUNT(*) AS total FROM likes WHERE post_id = ?");
$result->bind_param("i", $post_id);
$result->execute();
$row = $result->get_result()->fetch_assoc();

// Return JSON response
echo json_encode([
    "success" => true,
    "liked" => $liked,
    "likes" => $row['total']
]);
?>