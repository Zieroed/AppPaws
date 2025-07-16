<?php
$host = "localhost";
$username = "root";
$password = "";
$schemaFile = "database/happy_paws_schema.sql";
$newName = "init_DONE.php";

// Connect without selecting DB yet
$conn = mysqli_connect($host, $username, $password);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Load SQL file
$sql = file_get_contents($schemaFile);
if (!$sql) {
    die("Could not read SQL file.");
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
} else {
    echo "<p>Error setting up database: " . mysqli_error($conn) . "</p>";
}

mysqli_close($conn);
?>