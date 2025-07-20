function toggleLike(button) {
    const postElement = button.closest(".post");
    const postId = postElement.dataset.postId;

    fetch("/AppPaws/like_post.php", {
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

    fetch("/AppPaws/save_post.php", {
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

    const textarea = form.querySelector("textarea");
    const comment = textarea.value.trim();
    if (comment === "") return;

    const postElement = form.closest(".post");
    const postId = postElement.getAttribute("data-post-id");

    const formData = new FormData();
    formData.append("comment", comment);
    formData.append("post_id", postId);

    fetch("/AppPaws/save_comment.php", {
        method: "POST",
        body: formData
    })
    .then(response => {
        if (!response.ok) throw new Error("Network error");
        return response.json();
    })
    .then(data => {
        if (!data.success) throw new Error(data.message || "Failed to save comment");

        const newComment = document.createElement("div");
        newComment.className = "comment";
        newComment.innerHTML = `<strong>${data.username}</strong>: ${data.comment} <span class='timestamp'>· ${data.created_at}</span>`;

        // Insert new comment before the form
        form.parentNode.insertBefore(newComment, form);

        // Clear textarea
        textarea.value = "";

        // Update comment count
        const commentToggle = postElement.querySelector(".comment-toggle");
        let match = commentToggle.textContent.match(/\d+/);
        if (match) {
            const count = parseInt(match[0]) + 1;
            commentToggle.textContent = `${count} Comments`;
        }
    })
    .catch(err => {
        alert("Failed to post comment: " + err.message);
        console.error("Comment error:", err);
    });
}

document.addEventListener("DOMContentLoaded", function () {
    const fileInput = document.getElementById("postImage");
    const fileNameDisplay = document.getElementById("fileNameDisplay");

    fileInput.addEventListener("change", function () {
        const file = fileInput.files[0];
        fileNameDisplay.textContent = file ? `Selected file: ${file.name}` : "";
    }); 
});