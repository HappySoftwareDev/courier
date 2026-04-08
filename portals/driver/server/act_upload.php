<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, PATCH, DELETE');
header('Access-Control-Max-Age: 1000');

require_once '../../config/bootstrap.php';
require_once '../../function.php';

if ($_POST) {
    /* Getting file name */
    $filename = $_FILES['file']['name'];

    /* Location */
    $location = "sign_img/" . $filename;
    $uploadOk = 1;
    $imageFileType = pathinfo($location, PATHINFO_EXTENSION);


    /* Upload file */

    if (move_uploaded_file($_FILES['file']['tmp_name'], $location)) {
        echo $location;
    } else {
        echo 0;
    }
}


