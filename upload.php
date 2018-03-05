<?php

if (!empty($_FILES)) {

    $tempFile = $_FILES['file']['tmp_name'];

    $targetPath = __DIR__.'/pictures/import/';

    $targetFile =  $targetPath. $_FILES['file']['name'];
    move_uploaded_file($tempFile,$targetFile); //6

}
?> 