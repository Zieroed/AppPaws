<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once("includes/db.php");
include("includes/header.php");

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["register"])) {
        include_once("accounts/register_handler.php");
    } elseif (isset($_POST["login"])) {
        include_once("accounts/login_handler.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Happy Paws</title>
    <link id="stylesheet" rel="stylesheet" href="css/style.css">
</head>
<body>
    <div id="nonregister" class="page-wrapper body">
        <main>
            <div class="container">
                <h1>Welcome to Happy Paws!</h1>
                <p>Your one-stop solution for pet care and community.</p>
            </div>
        </main>
    </div>


    <!-- Include the login and registration forms -->    
    <?php
    include("accounts/register_form.php");
    include("accounts/login_form.php");
    include_once("includes/footer.php");
    ?>
    <script src="js/main.js"></script>
</body>
</html>
