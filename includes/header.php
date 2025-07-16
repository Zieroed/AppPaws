<header id="main-header">
    <div class="container">
        <section class="top-bar">
            <div>
                <a class="title" onclick="window.location.reload()">Happy Paws Animal Care</a>
            </div> 
            <div class="header-right">
                <a class="active">Home</a>
                <a onclick="showRegister()">Appointment</a>
                <a onclick="showRegister()">Records</a>
                <a>Community</a> 
                <a>About</a>

                <?php if (isset($_SESSION["fname"])): ?>
                    <a>User: <?php echo $_SESSION["fname"] . $_SESSION["lname"]; ?></a>

                    <!-- Logout Form -->
                    <form id="myform" action="/AppPaws/accounts/logout.php" method="post" style="display:inline;">
                        <a id="logout" onclick="document.getElementById('myform').submit();">Log out</a>
                    </form>
                <?php else: ?>
                    <a id="signup" onclick="showRegister()">Sign up</a>
                    <a id="login" onclick="showLogin()">Log in</a>
                <?php endif; ?>
            </div>
        </section>
    </div>
</header>