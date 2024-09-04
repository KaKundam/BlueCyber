<?php
include('../db/connect.php');
session_start();

if (!isset($_SESSION['uid'])) {
    header("Location: login.php");
    exit();
}

$message_id = $_GET['message_id'];

// Xóa tin nhắn
$stmt = $conn->prepare("DELETE FROM messages WHERE message_id = ? AND sender_id = ?");
$stmt->bind_param("ii", $message_id, $_SESSION['uid']);
$stmt->execute();

echo 'Xóa tin nhắn thành công';
header("Refresh:0.5, Location: view_message.php");
exit();
?>
