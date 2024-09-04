<?php
include '../db/connect.php';

$uid = $_GET['id'];

$sql = "SELECT * FROM student WHERE uid = $uid";
$result = $conn->query($sql);
$student = $result->fetch_assoc();

$conn->close();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Thông Tin Sinh Viên</title>
</head>
<body>
    <h2>Sửa Thông Tin Sinh Viên</h2>
    <form action="edit_student_process.php" method="post">
        <input type="hidden" name="uid" value="<?php echo $student['uid']; ?>">
        <input type="text" name="username" value="<?php echo $student['username']; ?>" required><br>
        <input type="password" name="password" placeholder="Mật khẩu mới (để trống nếu không đổi)"><br>
        <input type="text" name="name" value="<?php echo $student['name']; ?>" required><br>
        <input type="email" name="mail" value="<?php echo $student['mail']; ?>" required><br>
        <input type="text" name="phone_number" value="<?php echo $student['phone_number']; ?>" required><br>
        <input type="submit" value="Cập Nhật Thông Tin">
    </form>
</body>
</html>
