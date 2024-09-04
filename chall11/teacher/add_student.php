<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Sinh Viên</title>
</head>
<body>
    <h2>Thêm Sinh Viên</h2>
    <form action="add_student_process.php" method="post">
        <input type="text" name="username" placeholder="Tên đăng nhập" required><br>
        <input type="password" name="password" placeholder="Mật khẩu" required><br>
        <input type="text" name="name" placeholder="Họ tên" required><br>
        <input type="email" name="mail" placeholder="Email" required><br>
        <input type="text" name="phone_number" placeholder="Số điện thoại" required><br>
        <input type="submit" value="Thêm Sinh Viên">
    </form>
    <p><a href="teacher_dashboard.php">Return Dashboard</a></p>
</body>
</html>
