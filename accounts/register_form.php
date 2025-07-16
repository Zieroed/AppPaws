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
                <input type="text" id="phone" name="phone" placeholder="Phone number" required>
            </div>
            <div>
                <input type="text" id="email" name="email" placeholder="Email" required>
            </div>
            <div>
                <input type="password" id="pass" name="pass" placeholder="Password" minlength="8" required>
            </div>
            <div>
                <input type="password" id="confirm_pass" name="confirm_pass" placeholder="Confirm Password" minlength="8" required><br>
            </div>
            <div>
                <input class="submit" type="submit" name="register" value="Create">
            </div>
        </form>
    </div>
</div>