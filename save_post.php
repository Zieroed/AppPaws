<?php
session_start();
include_once("includes/db.php");

$response = ["success" => false];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'] ?? null;
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $image_path = null;

    if (!$user_id || empty($content)) {
        echo json_encode($response);
        exit;
    }

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        $filename = uniqid() . "_" . basename($_FILES['image']['name']);
        $targetPath = $uploadDir . $filename;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
            $image_path = $targetPath;
        }
    }

    $stmt = $conn->prepare("INSERT INTO posts (user_id, content, image_path) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $user_id, $content, $image_path);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
    // Fetch the username from DB
    $user_query = $conn->prepare("SELECT username FROM users WHERE id = ?");
    $user_query->bind_param("i", $user_id);
    $user_query->execute();
    $user_result = $user_query->get_result();
    $user = $user_result->fetch_assoc();

    $response["success"] = true;
    $response["post"] = [
        "content" => nl2br(htmlspecialchars($content)),
        "image" => $image_path,
        "time" => date("M d"),
        "username" => $user['username'] ?? "You"
    ];

    $user_query->close();
}

    $stmt->close();
}

echo json_encode($response);
?>