<?php 
// Include the AWS SDK autoloader 
require 'vendor/autoload.php'; 
use Aws\S3\S3Client; 
 
// Amazon S3 API credentials 
// AWS_REGION
$region = 'ap-southeast-2'; 
$version = 'latest'; 
// AWS_ACCESS_KEY
$access_key_id = 'AKIA6ODU2ZCHZU4KNZMM'; 
// AWS_SECRET_KEY
$secret_access_key = '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'; 
// S3_BUCKET_NAME
$bucket = 'sampel'; 
 
 
$statusMsg = ''; 
$status = 'danger'; 
 
// If file upload form is submitted 
if(isset($_POST["submit"])){ 
    // Check whether user inputs are empty 
    if(!empty($_FILES["userfile"]["name"])) { 
        // File info 
        $file_name = basename($_FILES["userfile"]["name"]); 
        $file_type = pathinfo($file_name, PATHINFO_EXTENSION); 
         
        // Allow certain file formats 
        $allowTypes = array('pdf','doc','docx','xls','xlsx','jpg','png','jpeg','gif'); 
        if(in_array($file_type, $allowTypes)){ 
            // File temp source 
            $file_temp_src = $_FILES["userfile"]["tmp_name"]; 
             
            if(is_uploaded_file($file_temp_src)){ 
                // Instantiate an Amazon S3 client 
                $s3 = new S3Client([ 
                    'version' => $version, 
                    'region'  => $region, 
                    'credentials' => [ 
                        'key'    => $access_key_id, 
                        'secret' => $secret_access_key, 
                    ],
                ]); 
 
                // Upload file to S3 bucket 
                try { 
                    $result = $s3->putObject([ 
                        'Bucket' => $bucket, 
                        'Key'    => $file_name, 
                        'ACL'    => 'public-read', 
                        'SourceFile' => $file_temp_src 
                    ]); 
                    $result_arr = $result->toArray(); 
                     
                    if(!empty($result_arr['ObjectURL'])) { 
                        $s3_file_link = $result_arr['ObjectURL']; 
                    } else { 
                        $api_error = 'Upload Failed! S3 Object URL not found.'; 
                    } 
                } catch (Aws\S3\Exception\S3Exception $e) { 
                    $api_error = $e->getMessage(); 
                } 
                 
                if(empty($api_error)){ 
                    $status = 'success'; 
                    $statusMsg = "File was uploaded to the S3 bucket successfully!"; 
                }else{ 
                    $statusMsg = $api_error; 
                } 
            }else{ 
                $statusMsg = "File upload failed!"; 
            } 
        }else{ 
            $statusMsg = 'Sorry, only Word/Excel/Image files are allowed to upload.'; 
        } 
    }else{ 
        $statusMsg = 'Please select a file to upload.'; 
    } 
} 

/*
sudo apt-get update
sudo apt install php-cli unzip
cd ~
curl -sS https://getcomposer.org/installer -o /tmp/composer-setup.php
HASH=`curl -sS https://composer.github.io/installer.sig`
echo $HASH
php -r "if (hash_file('SHA384', '/tmp/composer-setup.php') === '$HASH') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
sudo php /tmp/composer-setup.php --install-dir=/usr/local/bin --filename=composer
composer

cd /var/www/html/
sudo composer require aws/aws-sdk-php

sudo apt install awscli
aws s3 ls s3://DOC-EXAMPLE-BUCKET
*/
?>