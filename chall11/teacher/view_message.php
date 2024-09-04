<?php
session_start();
include '../db/connect.php';

$sender_id = $_SESSION["uid"];
$sql = "SELECT * FROM messages WHERE sender_id=$sender_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>Người nhận</th>
                <th>Nội dung</th>
                <th>Ngày gửi</th>
                <th>Hành động</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        $id_now = $row["message_id"];
        $htmlSnippet = '<form action="modify_message.php" method="post">
            <input type="hidden" name="message_id" value='.$id_now.'>
            <textarea name="message" required></textarea>
            <button type="submit">Chỉnh sửa</button>
        </form>'.'<form action="delete_message.php" method="post">
            <input type="hidden" name="message_id" value='.$id_now.'>
            <button type="submit">Xóa</button>
        </form>';
        echo "<tr>
                <td>" . $row['receiver_id'] . "</td>
                <td>" . $row['message'] . "</td>
                <td>" . $row['created_at'] . "</td>
                <td>" . $htmlSnippet . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "Không có sinh viên nào.";
}

$conn->close();
?>
<p><a href="teacher_dashboard.php">Return Dashboard</a></p>