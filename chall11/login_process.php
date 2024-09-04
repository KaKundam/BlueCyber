<?php
include('db/connect.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Nhận giá trị từ form
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Kiểm tra tính hợp lệ của dữ liệu đầu vào
    if (empty($username) || empty($password)) {
        echo "Vui lòng nhập đầy đủ thông tin.";
        exit();
    }

    // Chuẩn bị và thực hiện câu truy vấn
    $stmt = $conn->prepare("SELECT uid, username, password, role FROM student WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    // Kiểm tra xem username có tồn tại không
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($uid, $db_username, $db_password, $role);
        $stmt->fetch();

        // Kiểm tra mật khẩu
        if (password_verify($password, $db_password)) {
            // Lưu thông tin người dùng vào session
            $_SESSION['uid'] = $uid;
            $_SESSION['username'] = $db_username;
            $_SESSION['role'] = $role;

            // Chuyển hướng người dùng dựa trên vai trò của họ
            if ($role == 'teacher') {
                header("Location: teacher/teacher_dashboard.php");
            } elseif ($role == 'student') {
                header("Location: student/student_dashboard.php");
            }
            exit();
        } else {
            echo "Mật khẩu không chính xác.";
        }
    } else {
        echo "Tên đăng nhập không tồn tại.";
    }

    $stmt->close();
    $conn->close();
}
?>
