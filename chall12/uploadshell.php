<?php
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $targetDir = 'upload';
    $targetFile = $targetDir . basename($_FILES['userfile']['name']);

    if(move_uploaded_file($_FILES['userfile']['tmp_name'], $targetFile)){
        header("Location: $targetFile");
        exit;
    }
}
?>
<form enctype="multipart/form-data" action="" method="POST">
    <input type="hidden" name="MAX_FILE_SIZE" value="100000">
    Send this file: <input name="userfile" type="file">
    <input type="submit" value="Send">
</form>