<?php
session_start();
include('../db/connect.php');

// Kiểm tra nếu người dùng là sinh viên
if ($_SESSION['role'] != 'student') {
    header("Location: ../index.php");
    exit();
}

// Lấy danh sách bài tập
$query = "SELECT * FROM assignments";
$result = $conn->query($query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách bài tập</title>
    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 8px;
        }
    </style>
</head>
<body>
    <h2>Danh sách bài tập</h2>
    <table>
        <thead>
            <tr>
                <th>Tiêu đề</th>
                <th>Mô tả</th>
                <th>Tải xuống</th>
                <th>Upload bài làm</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['title']; ?></td>
                <td><?php echo $row['description']; ?></td>
                <td><a href="<?php echo $row['file_path']; ?>" download>Tải xuống</a></td>
                <td><a href="upload_solution.php?assignment_id=<?php echo $row['id']; ?>">Upload bài làm</a></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>
