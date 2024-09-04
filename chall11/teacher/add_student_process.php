<?php
include '../db/connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $name = $_POST['name'];
    $mail = $_POST['mail'];
    $phone_number = $_POST['phone_number'];

    $sql = "INSERT INTO student (username, password, name, mail, phone_number) 
            VALUES ('$username', '$password', '$name', '$mail', '$phone_number')";

    if ($conn->query($sql) === TRUE) {
        echo "Thêm sinh viên thành công!";
        $newLocation = 'teacher_dashboard.php';
        header('Refresh: 1; url=' . $newLocation);
        exit;
    } else {
        echo "Lỗi: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
