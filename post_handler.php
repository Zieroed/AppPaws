<?php
session_start();
include_once("includes/db.php");

$user_id = $_SESSION['user_id'];
$content = $_POST['content'];
$image_path = null;

if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
    $targetDir = "uploads/";
    $image_path = $targetDir . basename($_FILES["image"]["name"]);
    move_uploaded_file($_FILES["image"]["tmp_name"], $image_path);
}

$stmt = $conn->prepare("INSERT INTO posts (user_id, content, image_path) VALUES (?, ?, ?)");
$stmt->bind_param("iss", $user_id, $content, $image_path);
$stmt->execute();

echo "success";
$response["post"] = [
    "id" => $conn->insert_id,
    "content" => nl2br(htmlspecialchars($content)),
    "image" => $image_path,
    "time" => date("M d"),
    "username" => "You"
];
?>