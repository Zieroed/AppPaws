<?php
session_start();
include("includes/db.php");

if (!isset($_SESSION['user_id']) || !isset($_POST['post_id']) || !isset($_POST['content'])) {
    echo json_encode(["success" => false]);
    exit;
}

$user_id = $_SESSION['user_id'];
$post_id = $_POST['post_id'];
$content = trim($_POST['content']);

$stmt = $conn->prepare("INSERT INTO comments (user_id, post_id, content) VALUES (?, ?, ?)");
$stmt->bind_param("iis", $user_id, $post_id, $content);
$stmt->execute();

$username = $_SESSION['username'] ?? 'You';

echo json_encode([
    "success" => true,
    "username" => htmlspecialchars($username),
    "content" => htmlspecialchars($content)
]);
?>