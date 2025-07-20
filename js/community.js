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
    console.log("Submit triggered"); // Add this
    const text = form.querySelector("textarea").value.trim();
    if (text === "") return;

    const postElement = form.closest(".post");
    const postId = postElement.dataset.postId;

    fetch("/AppPaws/comment_post.php", {
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