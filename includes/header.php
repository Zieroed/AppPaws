<header id="main-header">
    <div class="container">
        <section class="top-bar" style="display: flex; align-items: center; justify-content: space-between;">
            <div style="flex: 1; display: flex; align-items: center; gap: 20px;">
                <a class="title" href="/AppPaws/index.php" style="display: flex; align-items: center; gap: 10px;">
                    <img src="/AppPaws/assets/logo.png" alt="Logo" style="height:60px; width:auto; display:block;">
                    <img src="/AppPaws/assets/title.jpg" alt="Title" style="height:60px; width:auto; display:block;">
                </a>
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                    <a href="/AppPaws/admin/dashboard.php" class="<?php echo ($current == 'dashboard.php') ? 'active' : ''; ?>">Dashboard</a>
                <?php endif; ?>
                
            </div>
            <div class="header-right" style="flex: 2; display: flex; justify-content: flex-end; align-items: center;">
                <?php
                $current = basename($_SERVER['PHP_SELF']);
                ?>
                <a href="/AppPaws/index.php" class="<?php echo ($current == 'index.php') ? 'active' : ''; ?>">Home</a>

                <?php if (isset($_SESSION["fname"])): ?>
                    <a href="/AppPaws/appointment.php" class="<?php echo ($current == 'appointment.php') ? 'active' : ''; ?>">Appointment</a>
                <?php else: ?>
                    <a onclick="showRegister()">Appointment</a>
                <?php endif; ?>
                
                <?php if (isset($_SESSION["fname"])): ?>
                    <a href="/AppPaws/records.php" class="<?php echo ($current == 'records.php') ? 'active' : ''; ?>">Records</a>
                <?php else: ?>
                    <a onclick="showRegister()">Records</a>
                <?php endif; ?>

                <?php if (isset($_SESSION["fname"])): ?>
                    <a href="/AppPaws/community.php" class="<?php echo ($current == 'community.php') ? 'active' : ''; ?>">Community</a>
                <?php else: ?>
                    <a onclick="showRegister()">Community</a>
                <?php endif; ?>

                <a href="/AppPaws/about.php" class="<?php echo ($current == 'about.php') ? 'active' : ''; ?>">About</a>

                <?php if (isset($_SESSION["fname"])): ?>
                    <a>User: <?php echo $_SESSION["fname"] . $_SESSION["lname"]; ?></a>

                    <!-- Logout Form as button styled like a link -->
                    <form id="myform" action="/AppPaws/accounts/logout.php" method="post" style="margin:0; padding:0; border:none; background:none; display:inline;">
                        <button id="logout" type="submit">Log out</button>
                    </form>
                <?php else: ?>
                    <a id="signup" onclick="showRegister()">Sign up</a>
                    <a id="login" onclick="showLogin()">Log in</a>
                <?php endif; ?>
            </div>
        </section>
    </div>
</header>