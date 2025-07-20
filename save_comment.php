<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once("includes/db.php");

header('Content-Type: application/json');

$user_id = $_SESSION['user_id'] ?? 0;
$post_id = $_POST['post_id'] ?? 0;
$comment = trim($_POST['comment'] ?? '');

if ($user_id == 0 || $post_id == 0 || $comment === '') {
    echo json_encode(["success" => false, "message" => "Invalid input"]);
    exit;
}

$comment = mysqli_real_escape_string($conn, $comment);

$query = "INSERT INTO comments (user_id, post_id, comment, created_at) VALUES (?, ?, ?, NOW())";
$stmt = $conn->prepare($query);
$stmt->bind_param("iis", $user_id, $post_id, $comment);

if ($stmt->execute()) {
    $userQuery = $conn->prepare("SELECT username FROM users WHERE id = ?");
    $userQuery->bind_param("i", $user_id);
    $userQuery->execute();
    $userResult = $userQuery->get_result()->fetch_assoc();

    echo json_encode([
        "success" => true,
        "username" => $userResult['username'],
        "comment" => nl2br(htmlspecialchars($comment)),
        "created_at" => date("M d")
    ]);
} else {
    echo json_encode(["success" => false, "message" => "DB error"]);
}