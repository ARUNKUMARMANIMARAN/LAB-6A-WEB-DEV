<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css" />
</head>
<body>
<?php
require('db.php');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'], $_POST['password'])) {
    // Sanitize and escape user input
    $username = stripslashes($_POST['username']);
    $username = mysqli_real_escape_string($con, $username);

    $password = stripslashes($_POST['password']);
    $password = mysqli_real_escape_string($con, $password);

    // Prepared statement to prevent SQL injection
    $query = "SELECT * FROM `users` WHERE username=? AND password=?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "ss", $username, $password);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) == 1) {
        // Username and password match, set session variables
        $_SESSION['username'] = $username;

        // Redirect user to the next page
        header("Location: index.php");
        exit();
    } else {
        // Invalid username or password
        echo "<div class='form'>
                <h3>Username/password is incorrect.</h3>
                <br/>Click here to <a href='login.php'>Login</a></div>";
    }

    // Close statement
    mysqli_stmt_close($stmt);
}
?>
<div class="form">
    <h1>Log In</h1>
    <form action="" method="post" name="login">
        <input type="text" name="username" placeholder="Username" required />
        <input type="password" name="password" placeholder="Password" required />
        <input name="submit" type="submit" value="Login" />
    </form>
    <p>Not registered yet? <a href='registration.php'>Register Here</a></p>
</div>
</body>
</html>