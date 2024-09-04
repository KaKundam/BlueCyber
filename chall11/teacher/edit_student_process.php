<?php
include '../db/connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uid = $_POST['uid'];
    $username = $_POST['username'];
    $name = $_POST['name'];
    $mail = $_POST['mail'];
    $phone_number = $_POST['phone_number'];

    $sql = "UPDATE student SET username='$username', name='$name', mail='$mail', phone_number='$phone_number'";

    // Chỉ cập nhật mật khẩu nếu người dùng nhập mật khẩu mới
    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $sql .= ", password='$password'";
    }

    $sql .= " WHERE uid=$uid";

    if ($conn->query($sql) === TRUE) {
        echo "Cập nhật thông tin thành công!";
        $newLocation = 'teacher_dashboard.php';
        header('Refresh: 1; url=' . $newLocation);
        exit;
    } else {
        echo "Lỗi: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
