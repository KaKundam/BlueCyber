
<?php
include('../db/connect.php');
session_start();

if ($_SESSION['role'] !== 'student') {
    header("Location: ../login.php");
    exit();
}

$uid = $_POST['challenge_id'];
$answer_student = $_POST['answer'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $answer = "SELECT * FROM challenge WHERE challenge_id=$uid";
    $result = $conn->query($answer);
    $row = $result->fetch_assoc();
    $answer = $row["title"];
    if ($answer == $answer_student) {
        $stmt = $conn->prepare("SELECT file_path FROM challenge WHERE challenge_id = ?");
        $stmt->bind_param("i", $uid);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $file_path = $row['file_path'];
                
                // Đọc nội dung file .txt và hiển thị
                if (file_exists($file_path)) {
                    $file_content = file_get_contents($file_path);
                    // echo "<h3>Content of the file: </h3>";
                    echo "<pre>" . htmlspecialchars($file_content) . "</pre>";
                } else {
                    echo "File không tồn tại.";
                }
            }
        } else {
            echo "Database lỗi rồi";
        }
    } else {
        echo "Chưa đúng đâu";
    }
}

$conn->close();
?>
<br>
<a href="student_challenge.php">Return</a>