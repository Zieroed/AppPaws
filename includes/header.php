<header id="main-header">
    <div class="container">
        <section class="top-bar">
            <div>
                <a class="title" onclick="window.location.reload()">Happy Paws Animal Care</a>
            </div> 
            <div class="header-right">
                <?php
                $current = basename($_SERVER['PHP_SELF']);
                ?>
                <a href="/AppPaws/index.php" class="<?php echo ($current == 'index.php') ? 'active' : ''; ?>">Home</a>
                <?php if (isset($_SESSION["fname"])): ?>
                    <a href="/AppPaws/appointment.php" class="<?php echo ($current == 'appointment.php') ? 'active' : ''; ?>">Appointment</a>
                <?php else: ?>
                    <a onclick="showRegister()">Appointment</a>
                <?php endif; ?>
                <a href="/AppPaws/records.php" class="<?php echo ($current == 'records.php') ? 'active' : ''; ?>">Records</a>
                <a href="/AppPaws/community.php" class="<?php echo ($current == 'community.php') ? 'active' : ''; ?>">Community</a>
                <a href="/AppPaws/about.php" class="<?php echo ($current == 'about.php') ? 'active' : ''; ?>">About</a>

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