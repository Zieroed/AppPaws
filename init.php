<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>AppPaws Setup</title>
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
        body {
            min-height: 100vh;
            width: 100vw;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fff7ed;
        }
        .init-fullscreen {
            width: 100vw;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Arial, sans-serif;
            font-size: 2rem;
        }
        .init-fullscreen h2, .init-fullscreen p {
            font-size: 2.5rem;
            margin: 1.5rem 0 1rem 0;
            text-align: center;
        }
        .init-fullscreen p {
            font-size: 1.5rem;
        }
        .big-btn {
            margin-top: 2.5rem;
            padding: 1.5rem 4rem;
            font-size: 2rem;
            border-radius: 40px;
            background: #f88624;
            color: white;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 16px rgba(0,0,0,0.08);
            transition: background 0.2s, box-shadow 0.2s;
        }
        .big-btn:hover {
            background: #ff9c4a;
            box-shadow: 0 6px 24px rgba(0,0,0,0.12);
        }
    </style>
</head>
<body>
<div class="init-fullscreen">
<?php
$host = "localhost";
$username = "root";
$password = "";
$schemaFile = "database/happy_paws_schema.sql";
$newName = "init_DONE.php";

// Connect without selecting DB yet
$conn = mysqli_connect($host, $username, $password);
if (!$conn) {
    echo "<h2>Connection failed: " . mysqli_connect_error() . "</h2>";
    exit();
}

// Load SQL file
$sql = file_get_contents($schemaFile);
if (!$sql) {
    echo "<h2>Could not read SQL file.</h2>";
    exit();
}

// Multi-query allows multiple SQL statements
if (mysqli_multi_query($conn, $sql)) {
    echo "<h2>Database and tables created successfully!</h2>";

    // Rename init.php to prevent re-running
    $currentFile = __FILE__;
    if (rename($currentFile, dirname(__FILE__) . '/' . $newName)) {
        echo "<p>init.php has been renamed to <strong>$newName</strong>.</p>";
    } else {
        echo "<p>Could not rename init.php. Please do it manually.</p>";
    }
    echo '<a href="index.php"><button class="big-btn">Go to AppPaws Home</button></a>';
} else {
    echo "<h2>Error setting up database: " . mysqli_error($conn) . "</h2>";
}

mysqli_close($conn);
?>
</div>
</body>
</html>