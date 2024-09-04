<?php
include('../db/connect.php');
session_start();

if (!isset($_SESSION['uid'])) {
    header("Location: login.php");
    exit();
}

$uid = $_SESSION['uid'];

$sql = "SELECT * FROM student";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>UID</th>
                <th>Tên đăng nhập</th>
                <th>Họ tên</th>
                <th>Email</th>
                <th>Số điện thoại</th>
                <th>Hành động</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        if ($row["uid"] == $uid) {
            continue;
        }
        $id_now= $row["uid"];
        $htmlSnippet = '<form action="send_message.php" method="post">
            <input type="hidden" name="receiver_id" value='.$id_now.'>
            <textarea name="message" required></textarea>
            <button type="submit">Gửi</button>
        </form>';

        echo "<tr>
                <td>" . $id_now . "</td>
                <td>" . $row['username'] . "</td>
                <td>" . $row['name'] . "</td>
                <td>" . $row['mail'] . "</td>
                <td>" . $row['phone_number'] . "</td>
                <td>" . $htmlSnippet . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "Không có sinh viên nào.";
}

echo "Tin nhắn đang chờ";

$message_stmt = $conn->prepare("SELECT m.message_id, m.message, m.created_at, m.updated_at, u.username AS sender 
                                FROM messages m 
                                JOIN student u ON m.sender_id = u.uid 
                                WHERE m.receiver_id = ? 
                                ORDER BY m.created_at DESC");
$message_stmt->bind_param("i", $uid);
$message_stmt->execute();
$messages = $message_stmt->get_result();
if ($messages->num_rows > 0) {
    while ($msg = $messages->fetch_assoc()) {
        echo "<div>";
        echo "<p><strong>" . $msg['sender'] . "</strong> (" . $msg['created_at'] . ")";
        if ($msg['updated_at']) {
            echo " - Sửa lần cuối: " . $msg['updated_at'];
        }
        echo "</p>";
        echo "<p>" . $msg['message'] . "</p>";
        if ($_SESSION['uid'] == $msg['sender']) {
            echo "<a href='edit_message.php?message_id=" . $msg['message_id'] . "'>Sửa</a> | ";
            echo "<a href='delete_message.php?message_id=" . $msg['message_id'] . "' onclick='return confirm(\"Bạn có chắc muốn xóa tin nhắn này?\");'>Xóa</a>";
        }
        echo "</div>";
    }
} else {
    echo "<p>Không có tin nhắn nào.</p>";
}

$conn->close();
?>

<p><a href="teacher_dashboard.php">Return Dashboard</a></p>