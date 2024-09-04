<?php
session_start();
include('../db/connect.php');

// Kiểm tra nếu người dùng là giáo viên
if ($_SESSION['role'] != 'teacher') {
    header("Location: ../index.php");
    exit();
}

$assignment_id = $_GET['assignment_id'];

// Lấy danh sách bài làm của sinh viên
$query = "SELECT s.*, st.username FROM submissions s JOIN student st ON s.student_id = st.uid WHERE s.assignment_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $assignment_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách bài làm của sinh viên</title>
    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 8px;
        }
    </style>
</head>
<body>
    <h2>Danh sách bài làm của sinh viên</h2>
    <table>
        <thead>
            <tr>
                <th>Tên sinh viên</th>
                <th>Bài làm</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['username']; ?></td>
                <td><a href="<?php echo $row['file_path']; ?>" download>Tải xuống</a></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <p><a href="teacher_dashboard.php">Return Dashboard</a></p>
</body>
</html>
