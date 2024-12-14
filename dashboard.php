<?php
require('db.php'); 
include("auth.php"); // Includes session validation.
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Dashboard - Secured Page</title>
    <link rel="stylesheet" href="css/style.css" />
</head>
<body>
<div class="form">
    <p>Welcome to Dashboard, <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong>.</p>
    <p><a href="index.php">Home</a></p>
    <p><a href="insert.php">Insert New Record</a></p>
    <p><a href="view.php">View Records</a></p>
    <p><a href="logout.php">Logout</a></p>
</div>
</body>
</html>