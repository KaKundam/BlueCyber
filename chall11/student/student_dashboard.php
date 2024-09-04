<?php
session_start();

if ($_SESSION['role'] !== 'student') {
    header("Location: ../login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="form-container">
        <h2>Welcome, <?php echo $_SESSION['username']; ?></h2>
        <p><a href="edit_profile.php">Edit Profile</a></p>
        <p></p><a href="student_assignments.php">Assignment</a></p>
        <p></p><a href="student_challenge.php">Challenge</a></p>
        <p><a href="view_user.php">View Users</a></p>
        <p><a href="../logout.php">Logout</a></p>
    </div>
</body>
</html>
