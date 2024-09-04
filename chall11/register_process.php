<?php
session_start();
include 'db/connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form đăng ký
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $name = $_POST['name'];
    $mail = $_POST['mail'];
    $phone_number = $_POST['phone_number'];

    // Kiểm tra tính hợp lệ của dữ liệu đầu vào
    if (empty($username) || empty($password) || empty($confirm_password) || empty($name) || empty($mail) || empty($phone_number)) {
        echo "Vui lòng điền đầy đủ các trường.";
        exit;
    }

    if ($password !== $confirm_password) {
        echo "Mật khẩu không khớp.";
        exit;
    }

    // Kiểm tra nếu username đã tồn tại
    $sql = "SELECT uid FROM student WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "Tên đăng nhập đã tồn tại. Vui lòng chọn tên khác.";
        exit;
    }

    // Mã hóa mật khẩu
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Chèn dữ liệu vào cơ sở dữ liệu
    $sql = "INSERT INTO student (username, password, name, mail, phone_number) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $username, $hashed_password, $name, $mail, $phone_number);

    if ($stmt->execute()) {
        echo "Đăng ký thành công! Bạn có thể đăng nhập.";
        // Chuyển hướng người dùng tới trang đăng nhập
        header("Location: login.php");
        exit;
    } else {
        echo "Đã xảy ra lỗi. Vui lòng thử lại.";
    }

    // Đóng kết nối
    $stmt->close();
    $conn->close();
} else {
    echo "Yêu cầu không hợp lệ.";
    exit;
}
?>
