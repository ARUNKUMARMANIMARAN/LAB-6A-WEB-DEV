<?php
require('db.php');
include("auth.php");

// Retrieve the record ID from the query string and sanitize it
$id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;

// Fetch the existing record
$query = "SELECT * FROM new_record WHERE id = ?";
$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$result || mysqli_num_rows($result) == 0) {
    echo "<p>Record not found. <a href='view.php'>Go back</a></p>";
    exit();
}

$row = mysqli_fetch_assoc($result);

// Handle form submission
$status = "";
if (isset($_POST['new']) && $_POST['new'] == 1) {
    // Sanitize user input
    $name = mysqli_real_escape_string($con, stripslashes($_POST['name']));
    $age = intval($_POST['age']);
    $trn_date = date("Y-m-d H:i:s");
    $submittedby = $_SESSION["username"];

    // Update the record
    $update = "UPDATE new_record SET trn_date = ?, name = ?, age = ?, submittedby = ? WHERE id = ?";
    $stmt = mysqli_prepare($con, $update);
    mysqli_stmt_bind_param($stmt, "ssisi", $trn_date, $name, $age, $submittedby, $id);

    if (mysqli_stmt_execute($stmt)) {
        $status = "Record updated successfully.<br><br><a href='view.php'>View Updated Record</a>";
    } else {
        $status = "Error updating record: " . mysqli_error($con);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Update Record</title>
    <link rel="stylesheet" href="css/style.css" />
</head>
<body>
<div class="form">
    <p><a href="dashboard.php">Dashboard</a> | <a href="insert.php">Insert New Record</a> | <a href="logout.php">Logout</a></p>
    <h1>Update Record</h1>

    <?php if ($status): ?>
        <p style="color: #FF0000;"><?php echo $status; ?></p>
    <?php else: ?>
        <form name="form" method="post" action="">
            <input type="hidden" name="new" value="1" />
            <input name="id" type="hidden" value="<?php echo htmlspecialchars($row['id']); ?>" />
            <p><input type="text" name="name" placeholder="Enter Name" required value="<?php echo htmlspecialchars($row['name']); ?>" /></p>
            <p><input type="number" name="age" placeholder="Enter Age" required value="<?php echo htmlspecialchars($row['age']); ?>" /></p>
            <p><input name="submit" type="submit" value="Update" /></p>
        </form>
    <?php endif; ?>
</div>
</body>
</html>