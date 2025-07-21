<!--Registration Popup-->
<div class="hidden" id="register">
    <div class="registration">
        <span class="close" onclick="closeRegister()">&times</span>
        <h2 style="color: #f88624;">Become a Paw-tner</h2>
        <p>Join the pack and enjoy the purr-mium care that'll have tails wagging and whiskers twitching!</p>
        
        <form action="index.php" method="post" onsubmit="return confirmPassword()">
            <div class="row name">
                <input type="text" id="fname" name="fname" placeholder="First Name" required>
                <input type="text" id="lname" name="lname" placeholder="Last Name" required>
            </div>
            <div>
                <input type="text" id="phone" name="phone" placeholder="Phone number" required
                pattern="^(\+63|0)?9\d{9}$" title="Enter a valid PH mobile number (e.g., 09123456789)">
            </div>
            <div>
                <input type="text" id="email" name="email" placeholder="Email" required
                pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$"
                title="Enter a valid email address (e.g., name@example.com)">
            </div>
            <div>
                <input type="password" id="pass" name="pass" placeholder="Password" minlength="8" required>
            </div>
            <div>
                <input type="password" id="confirm_pass" name="confirm_pass" placeholder="Confirm Password" minlength="8" required><br>
            </div>
            <?php if (isset($reg_error)): ?>
                <div class="helper-link"><?= htmlspecialchars($reg_error) ?></div>
            <?php endif; ?>
            <div>
                <input class="submit" type="submit" name="register" value="Create">
            </div>
        </form>

        <div class="form-footer-text">
            Ready to get back to business? 
            <a class="switch-to-register" onclick="switchToLogin()">We've fur real missed you!</a>
        </div>
    </div>
</div>
<?php if (isset($reg_error)): ?>
<script>
    window.addEventListener("DOMContentLoaded", () => {
        // Show registration form
        document.getElementById("register").classList.remove("hidden");

        // Hide login form
        const loginForm = document.getElementById("login-popup");
        if (loginForm) {
            loginForm.classList.add("hidden");
        }
    });
</script>
<?php endif; ?>