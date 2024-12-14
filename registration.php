<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Registration</title>
    <link rel="stylesheet" href="css/style.css" />
</head>
<body>
<?php
require('db.php'); // Ensure db.php contains your database connection code

// If form submitted, insert values into the database
if (isset($_REQUEST['username'])) {
    // Removes backslashes
    $username = stripslashes($_REQUEST['username']);
    $username = mysqli_real_escape_string($con, $username);
    
    $email = stripslashes($_REQUEST['email']);
    $email = mysqli_real_escape_string($con, $email);
    
    $password = stripslashes($_REQUEST['password']);
    $password = mysqli_real_escape_string($con, $password);
    
    // Get current timestamp for the registration date
    $trn_date = date("Y-m-d H:i:s");

    // Use prepared statement for security
    $query = "INSERT INTO `users` (username, password, email, trn_date) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($con, $query);
    
    // Bind parameters to the prepared statement
    mysqli_stmt_bind_param($stmt, "ssss", $username, $password, $email, $trn_date);

    // Execute the query
    if (mysqli_stmt_execute($stmt)) {
        echo "<div class='form'>
                <h3>You are registered successfully.</h3>
                <br/>Click here to <a href='login.php'>Login</a></div>";
    } else {
        echo "<div class='form'>
                <h3>Error during registration. Please try again.</h3></div>";
    }

    // Close the prepared statement
    mysqli_stmt_close($stmt);
} else {
?>
<div class="form">
    <h1>Registration</h1>
    <form name="registration" action="" method="post">
        <input type="text" name="username" placeholder="Username" required />
        <input type="email" name="email" placeholder="Email" required />
        <input type="password" name="password" placeholder="Password" required />
        <input type="submit" name="submit" value="Register" />
    </form>
</div>
<?php } ?>
</body>
</html>