<?php
session_start();
include('../db/connect.php');

if ($_SESSION['role'] != 'student') {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['solution_file'])) {
    $assignment_id = $_POST['assignment_id'];
    $student_id = $_SESSION['uid'];

    $target_dir = "../uploads/solutions/";
    $file_name = basename($_FILES["solution_file"]["name"]);
    $target_file = $target_dir . time() . "_" . $file_name;

    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    if (move_uploaded_file($_FILES["solution_file"]["tmp_name"], $target_file)) {

        $stmt = $conn->prepare("INSERT INTO submissions (assignment_id, student_id, file_path) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $assignment_id, $student_id, $target_file);
        $stmt->execute();

        echo "Bài làm đã được nộp thành công.";
        $newLocation = 'student_dashboard.php';
        header('Refresh: 1; url=' . $newLocation);
        exit;
    } else {
        echo "Có lỗi xảy ra khi tải lên file.";
    }
} else {
    $assignment_id = $_GET['assignment_id'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload bài làm</title>
</head>
<body>
    <h2>Upload bài làm của bạn</h2>
    <form action="upload_solution.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="assignment_id" value="<?php echo $assignment_id; ?>">
        <label for="solution_file">Chọn file bài làm:</label>
        <input type="file" name="solution_file" id="solution_file" required>
        <button type="submit">Nộp bài</button>
    </form>
</body>
</html>
