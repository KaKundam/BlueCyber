<?php
include('../db/connect.php');
session_start();

// Kiểm tra quyền truy cập
if ($_SESSION['role'] !== 'teacher') {
    header('Location: ../index.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['challenge_file'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $teacher_id = $_SESSION['uid'];

    $target_dir = "../uploads/challenge/";
    $file_name = basename($_FILES["challenge_file"]["name"]);
    $target_file = $target_dir . time() . "_" . $file_name;
    $uploadOk = 1;

    // Kiểm tra nếu thư mục không tồn tại, tạo nó
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    if (move_uploaded_file($_FILES["challenge_file"]["tmp_name"], $target_file)) {

        $stmt = $conn->prepare("INSERT INTO challenge (teacher_id, title, description, file_path) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $teacher_id, $title, $description, $target_file);
        $stmt->execute();

        echo "Bài tập đã được tải lên thành công.";
    } else {
        echo "Có lỗi xảy ra khi tải lên file.";
    }
}

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Challenge</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <h2>Upload Challenge</h2>
    <form action="upload_challenge.php" method="post" enctype="multipart/form-data">
        <label for="title">Title:</label>
        <input type="text" name="title" required><br>

        <label for="description">Description:</label>
        <textarea name="description"></textarea><br>

        <label for="challenge_file">Upload File:</label>
        <input type="file" name="challenge_file" required><br>

        <input type="submit" value="Upload Challenge">
    </form>
    <p><a href="teacher_dashboard.php">Return Dashboard</a></p>
</body>
</html>
