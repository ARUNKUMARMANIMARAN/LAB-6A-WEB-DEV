<?php
// Start the session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include the auth.php file to enforce authentication
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Welcome Home</title>
    <link rel="stylesheet" href="css/style.css" />
</head>
<body>
<div class="form">
    <h1>Welcome!</h1>
    <p>Hello, <strong><?php echo htmlspecialchars($_SESSION['username']); ?>!</strong></p>
    <p>You have successfully logged in. This is a secure area.</p>
    <p>
        <a href="dashboard.php">Go to Dashboard</a>
    </p>
    <p>
        <a href="logout.php">Logout</a>
    </p>
</div>
</body>
</html>