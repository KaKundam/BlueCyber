
<?php
include('../db/connect.php');
session_start();

if ($_SESSION['role'] !== 'student') {
    header("Location: ../login.php");
    exit();
}

$username = $_SESSION['username'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $sql = "UPDATE student SET mail='$email', phone_number='$phone' WHERE username='$username'";

    if ($conn->query($sql) === TRUE) {
        echo "Profile updated successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$sql = "SELECT * FROM student WHERE username='$username'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$conn->close();
?>

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
        <h2>Edit Profile</h2>
        <form method="post">
            <label for="email">Email:</label>
            <input type="email" name="email" value="<?php echo $row['mail']; ?>" required>

            <label for="phone">Phone:</label>
            <input type="text" name="phone" value="<?php echo $row['phone_number']; ?>" required>

            <button type="submit">Update Profile</button>
        </form>
        <p><a href="student_dashboard.php">Back to Dashboard</a></p>
    </div>
</body>
</html>
