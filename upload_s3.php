<?php
include_once 'upload.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container">
        <h5 class="mt-3">Upload File to Amazon S3</h5>
        <?php
            if (!empty($statusMsg)) {
                echo "<span class='badge badge-{$status}'>{$statusMsg}</span>";
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
                // echo "<span class='badge badge-{$status}'>{$statusMsg}</span>";
                // echo $s3_file_link;

                $link_img = "";
                switch ($file_type) {
                    case 'pdf':
                        $link_img = "https://storage.unikal.ac.id/data/apps/files/static/pdf.png";
                        break;
                    case 'doc':
                        $link_img = "https://storage.unikal.ac.id/data/apps/files/static/word.png";
                        break;
                    case 'docx':
                        $link_img = "https://storage.unikal.ac.id/data/apps/files/static/word.png";
                        break;
                    case 'xls':
                        $link_img = "https://storage.unikal.ac.id/data/apps/files/static/excel2.png";
                        break;
                    case 'xlsx':
                        $link_img = "https://storage.unikal.ac.id/data/apps/files/static/excel2.png";
                        break;
                    case 'jpg':
                        $link_img = $s3_file_link;
                        break;
                    case 'png':
                        $link_img = $s3_file_link;
                        break;
                    case 'jpeg':
                        $link_img = $s3_file_link;
                        break;
                    case 'gif':
                        $link_img = $s3_file_link;
                        break;
                    default:
                        $link_img = "https://storage.unikal.ac.id/data/apps/files/static/no-image.jpg";
                        break;
                }
            
            echo "<img src='{$link_img}' alt='image' class='img-thumbnail'>";
            }
        ?>
    </div>
</body>
</html>
