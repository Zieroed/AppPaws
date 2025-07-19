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

      while ($row = mysqli_fetch_assoc($result)) {
          $name = htmlspecialchars($row['name']);
          $username = htmlspecialchars($row['username'] ?? 'unknown');
          $content = nl2br(htmlspecialchars($row['content']));
          $created = date("M d", strtotime($row['created_at']));
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
                $c_time = date("M d", strtotime($comment['created_at']));
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
<script>
function toggleLike(button) {
    const postElement = button.closest(".post");
    const postId = postElement.dataset.postId;

    fetch("like_post.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "post_id=" + encodeURIComponent(postId)
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            const countSpan = button.nextElementSibling.querySelector('.like-count');
            countSpan.textContent = data.likes;
            button.classList.toggle("liked", data.liked);
        }
    });
}

function toggleComments(toggleBtn) {
    const post = toggleBtn.closest('.post');
    const commentSection = post.querySelector('.comment-section');
    commentSection.style.display = commentSection.style.display === 'none' ? 'block' : 'none';
}

function addPost() {
    const textarea = document.getElementById("postContent");
    const text = textarea.value.trim();
    const fileInput = document.getElementById("postImage");
    const file = fileInput.files[0];

    if (text === "") return;

    const formData = new FormData();
    formData.append("content", text);
    if (file) {
        formData.append("image", file);
    }

    fetch("save_post.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (!data.success) throw new Error("Failed to post");

        const postContainer = document.getElementById("posts");
        const postElement = document.createElement("div");
        postElement.className = "post";

        const imgHTML = data.post.image ? `<div class='image-row'><img src="${data.post.image}" alt="User uploaded image"></div>` : "";

        postElement.innerHTML = `
            <div class="user-info">${data.post.username} <span class="timestamp">@you · ${data.post.time}</span></div>
            <p>${data.post.content}</p>
            ${imgHTML}
            <div class="post-stats">
                <div class="likes-group">
                    <button class="heart-btn" onclick="toggleLike(this)">♥</button>
                    <span><span class="like-count">0</span> Likes</span>
                </div>
                <div class="comment-toggle" onclick="toggleComments(this)">0 Comments</div>
            </div>
            <div class="comment-section" style="display: none;">
                <form class="comment-form" onsubmit="submitComment(event, this)">
                    <textarea placeholder="Write a comment..."></textarea>
                    <div class="comment-controls">
                        <button type="submit">Comment</button>
                    </div>
                </form>
            </div>
        `;

        postContainer.prepend(postElement);
        textarea.value = "";
        fileInput.value = "";
        document.getElementById("fileNameDisplay").textContent = "";
        location.reload();
    })
    .catch(err => {
        console.error(err);
        alert("Something went wrong while posting.");
    });
}

function submitComment(event, form) {
    event.preventDefault();
    console.log("Submit triggered"); // Add this
    const text = form.querySelector("textarea").value.trim();
    if (text === "") return;

    const postElement = form.closest(".post");
    const postId = postElement.dataset.postId;

    fetch("comment_post.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "post_id=" + encodeURIComponent(postId) + "&content=" + encodeURIComponent(text)
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            const newComment = document.createElement("div");
            newComment.className = "reply";
            newComment.innerHTML = `
                <div class="user-info">${data.username} <span class="timestamp">· just now</span></div>
                <p>${data.content}</p>
                <div class="likes-group">
                    <button class="heart-btn" onclick="toggleLike(this)">♥</button>
                    <span><span class="like-count">0</span> Likes</span>
                </div>
            `;
            form.parentElement.insertBefore(newComment, form);
            form.querySelector("textarea").value = "";

            // Update comment count
            const toggle = postElement.querySelector(".comment-toggle");
            let count = parseInt(toggle.textContent) || 0;
            count++;
            toggle.textContent = `${count} Comment${count !== 1 ? "s" : ""}`;
        }
    });
}

document.addEventListener("DOMContentLoaded", function () {
    const fileInput = document.getElementById("postImage");
    const fileNameDisplay = document.getElementById("fileNameDisplay");

    fileInput.addEventListener("change", function () {
        const file = fileInput.files[0];
        fileNameDisplay.textContent = file ? `Selected file: ${file.name}` : "";
    });

    document.querySelectorAll('.comment-form').forEach(form => {
        form.addEventListener('submit', function (e) {
            submitComment(e, form);
        });
    });
});
</script>
</body>
</html>