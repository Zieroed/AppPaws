<!-- Login Popup -->
<div class="<?= isset($error) ? '' : 'hidden' ?>" id="login-popup">
    <div class="registration" >
        <span class="close" onclick="closeLogin()">&times;</span>
        <h2 style="color: #f88624;">Hop In</h2>
        <p>Welcome back to Happy Paws - where tails wag and care is never ruff!</p>

        <form method="post" action="index.php">
            <div>
                <input type="text" name="email" placeholder="Email" required>
            </div>
            <div>
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <?php if (isset($error)): ?>
                <div class="helper-link"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <div class="login-helper-text">
                <a class="helper-link" href="#">Having trouble signing in?</a>
            </div>
            <div>
                <input class="submit" type="submit" name="login" value="Log In">
            </div>
            <div class="login-footer-text">
                Don't have an account? 
                <a class="switch-to-register" onclick="switchToRegister()">We pawmise it'll be a fetching experience.</a>
            </div>
        </form>
    </div>
</div>