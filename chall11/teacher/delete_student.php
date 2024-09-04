<?php
include '../db/connect.php';

$uid = $_GET['id'];

$sql = "DELETE FROM student WHERE uid = $uid";

if ($conn->query($sql) === TRUE) {
    echo "Xóa sinh viên thành công!";
    $newLocation = 'teacher_dashboard.php';
    header('Refresh: 1; url=' . $newLocation);
    exit;
} else {
    echo "Lỗi: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
