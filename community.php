<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once("includes/db.php");
include("includes/header.php");
$user_id = $_SESSION['user_id'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Community - Happy Paws</title>
  <link rel="stylesheet" href="css/community.css">
</head>

<body>
<section class="community-section">
    <div class="community-title">🐾 Community</div>

    <div class="post-box">
      <textarea id="postContent" placeholder="Share your thoughts!"></textarea>
      <div class="upload-row">
        <label class="upload-label" for="postImage">Upload Image</label>
        <input type="file" id="postImage" accept="image/*">
        <div id="fileNameDisplay" class="file-name-display"></div>
        <div><button type="button" onclick="addPost()">Post</button></div>
      </div>
    </div>

    <div id="posts">
      <?php
      include_once("includes/db.php");

      // Fetch posts from database
      $query = "SELECT p.id, p.content, p.image_path, p.created_at, CONCAT(u.fname, ' ', u.lname) AS name, u.username,
       (SELECT COUNT(*) FROM likes WHERE post_id = p.id) AS like_count,
       (SELECT COUNT(*) FROM comments WHERE post_id = p.id) AS comment_count,
        EXISTS(SELECT 1 FROM likes WHERE post_id = p.id AND user_id = $user_id) AS user_liked
        FROM posts p
        JOIN users u ON p.user_id = u.id
        ORDER BY p.created_at DESC;";   
      $result = mysqli_query($conn, $query);

      function timeAgo($datetime) {
        $time = strtotime($datetime);
        $diff = time() - $time;

        if ($diff < 60) return 'Just now';
        if ($diff < 3600) return floor($diff / 60) . ' min' . (floor($diff / 60) > 1 ? 's' : '') . ' ago';
        if ($diff < 86400) return floor($diff / 3600) . ' hour' . (floor($diff / 3600) > 1 ? 's' : '') . ' ago';
        if ($diff < 604800) return floor($diff / 86400) . ' day' . (floor($diff / 86400) > 1 ? 's' : '') . ' ago';

        return date("M d", $time);
      }
      
      while ($row = mysqli_fetch_assoc($result)) {
          $name = htmlspecialchars($row['name']);
          $username = htmlspecialchars($row['username'] ?? 'unknown');
          $content = nl2br(htmlspecialchars($row['content']));
          $created = timeAgo($row['created_at']);
          $image = $row['image_path'] ? "<div class='image-row'><img src='{$row['image_path']}' alt='User image'></div>" : "";
            $post_id = $row['id'];
            $comments = [];

            $comment_result = $conn->query("SELECT c.comment, c.created_at, u.username 
                                            FROM comments c 
                                            JOIN users u ON c.user_id = u.id 
                                            WHERE c.post_id = $post_id 
                                            ORDER BY c.created_at ASC");

            if ($comment_result && $comment_result->num_rows > 0) {
                while ($c = $comment_result->fetch_assoc()) {
                    $comments[] = $c;
                }
            }
         $comment_html = "";
            foreach ($comments as $comment) {
                $c_user = htmlspecialchars($comment['username']);
                $c_text = nl2br(htmlspecialchars($comment['comment']));
                $c_time = timeAgo($comment['created_at']);
                $comment_html .= "<div class='comment'><strong>{$c_user}</strong>: {$c_text} <span class='timestamp'>· {$c_time}</span></div>";
            }
            $likedClass = $row['user_liked'] ? 'liked' : '';

            echo "
            <div class='post' data-post-id='{$row['id']}'>
                <div class='user-info'>{$username} <span class='timestamp'>· {$created}</span></div>
                <p>{$content}</p>
                {$image}
                <div class='post-stats'>
                <div class='likes-group'>
                    <button class='heart-btn $likedClass' onclick='toggleLike(this)'>♥</button>
                    <span><span class='like-count'>{$row['like_count']}</span> Likes</span>
                </div>
                <div class='comment-toggle' onclick='toggleComments(this)'>{$row['comment_count']} Comments</div>
                </div>
                <div class='comment-section' style='display: none;'>
                {$comment_html}
                <form class='comment-form' onsubmit='submitComment(event, this)'>
                    <textarea name='comment' placeholder='Write a comment...'></textarea>
                    <div class='comment-controls'>
                    <button type='submit'>Comment</button>
                    </div>
                </form>
                </div>
            </div>";
            }
      ?>
    </div>
</section>
<?php include("includes/footer.php"); ?>
<script src="js/community.js"></script>
</body>
</html>