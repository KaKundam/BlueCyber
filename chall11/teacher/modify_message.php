<?php
include('../db/connect.php');
session_start();

if (!isset($_SESSION['uid'])) {
    header("Location: login.php");
    exit();
}

$message_id = $_POST['message_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $message = $_POST['message'];

    $stmt = $conn->prepare("UPDATE messages SET message = ?, updated_at = NOW() WHERE message_id = ? AND sender_id = ?");
    $stmt->bind_param("sii", $message, $message_id, $_SESSION['uid']);
    $stmt->execute();

    echo "Đã sửa tin nhắn thành công";
} else {
    // Lấy tin nhắn hiện tại
    $stmt = $conn->prepare("SELECT message, receiver_id FROM messages WHERE message_id = ? AND sender_id = ?");
    $stmt->bind_param("ii", $message_id, $_SESSION['uid']);
    $stmt->execute();
    $message = $stmt->get_result()->fetch_assoc();
}
header('Refresh: 0.5; url=view_message.php');
?>
