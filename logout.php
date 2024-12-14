<?php
session_start();

// Destroying all sessions
if (session_status() === PHP_SESSION_ACTIVE) {
    session_destroy();
}

// Redirecting to the login page
header("Location: login.php");
exit();
?>