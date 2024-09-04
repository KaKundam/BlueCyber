<?php
include('../db/connect.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sender_id = $_SESSION['uid'];
    $receiver_id = $_POST['receiver_id'];
    $message = $_POST['message'];
    $stmt = $conn->prepare("INSERT INTO messages (sender_id, receiver_id, message) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $sender_id, $receiver_id, $message);
    $stmt->execute();

    echo "Đã gửi tin nhắn thành công";
    header('Refresh: 1; url=view_user.php' );
    //header("Location: user_detail.php?uid=" . $receiver_id);
    exit();
}
?>
