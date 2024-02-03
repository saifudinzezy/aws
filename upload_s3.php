<?php
include_once 'upload.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        if (!empty($statusMsg)) {
            echo $status;
            echo $statusMsg;
        }
    ?>
    <form method="post" action="" enctype="multipart/form-data">
        <div class="form-group">
            <label><b>Select File:</b></label>
            <input type="file" name="userfile" class="form-control" required>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" name="submit" value="Upload">
        </div>
    </form>

    <?php
        if (!empty($s3_file_link)) {
            echo $status;
            echo $statusMsg;
            echo $s3_file_link;
        }
    ?>
</body>
</html>