
<?php
include 'db/connect.php';

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
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row['uid'] . "</td>
                <td>" . $row['username'] . "</td>
                <td>" . $row['name'] . "</td>
                <td>" . $row['mail'] . "</td>
                <td>" . $row['phone_number'] . "</td>
                
              </tr>";
    }
    echo "</table>";
} else {
    echo "Không có sinh viên nào.";
}

$conn->close();
?>

<!-- <td>
    <a href='edit_student.php?uid=" . $row['uid'] . "'>Sửa</a> |
    <a href='delete_student.php?uid=" . $row['uid'] . "'>Xóa</a>
</td> -->