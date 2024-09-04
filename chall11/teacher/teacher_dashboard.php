<?php
include('../db/connect.php');
session_start();

if ($_SESSION['role'] !== 'teacher') {
    header("Location: ../login.php");
    exit();
}
$teacher_id=$_SESSION['uid'];

$stmt = $conn->prepare("SELECT * FROM assignments WHERE teacher_id = ?");
$stmt->bind_param("i", $teacher_id);
$stmt->execute();
$result = $stmt->get_result();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashboard</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="form-container">
        <h2>Welcome, <?php echo $_SESSION['username']; ?></h2>
        <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='assignment'>";
                    echo "<p><strong>Tiêu đề:</strong> " . $row['title'] . "</p>";
                    echo "<p><strong>Mô tả:</strong> " . $row['description'] . "</p>";
                    echo "<a href='teacher_view_solution.php?assignment_id=" . $row['id'] . "'>Xem bài nộp</a>";
                    echo "</div>";
                }
            } else {
                echo "<p>Bạn chưa có bài tập nào.</p>";
            }
        ?>
        <h3>Teacher Dashboard</h3>
        <table>
            <tr>
                <!-- <th>ID</th> -->
                <th>Username</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Action</th>
            </tr>
            <?php 
            $sql = "SELECT * FROM student WHERE role='student'";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <!-- <td><?php echo $row['id']; ?></td> -->
                <td><?php echo $row['username']; ?></td>
                <td><?php echo $row['mail']; ?></td>
                <td><?php echo $row['phone_number']; ?></td>
                <td>
                    <a href="edit_student.php?id=<?php echo $row['uid']; ?>">Edit</a>
                    <a href="delete_student.php?id=<?php echo $row['uid']; ?>">Delete</a>
                </td>
            </tr>
            <?php } ?>
        </table>
        <p><a href="add_student.php">Add New Student</a></p>
        <p><a href="upload_assignment.php">Upload New Assignment</a></p>
        <p><a href="upload_challenge.php">Upload New Challenge</a></p>
        <p><a href="view_message.php">Xem tin nhắn đã gửi</a></p>
        <p><a href="view_user.php">Xem tất cả người dùng và tin nhắn đã nhận</a></p>
        <p><a href="../index.php">Log Out</a></p>
    </div>
</body>
</html>


<?php
$conn->close();
?>

