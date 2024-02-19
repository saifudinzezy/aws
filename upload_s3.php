<?php
include_once 'upload.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous">
    </script>
</head>

<body>
    <?php
        if (!empty($statusMsg)) {
            echo $status;
            echo $statusMsg;
        }
    ?>
    <div class="container">
        <h1>Upload Berkas</h1>
        <hr>

        <form method="post" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label><b>Select File:</b></label>
                <input type="file" name="userfile" class="form-control" required>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" name="submit" value="Upload">
            </div>
        </form>
    </div>

    <?php
        if (!empty($s3_file_link)) {
            echo $status;
            echo $statusMsg;
            // echo $s3_file_link;
            echo "<img src='".$s3_file_link."' class='img-fluid'>";
        }
    ?>
</body>

</html>