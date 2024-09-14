<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, PATCH, DELETE');
header('Access-Control-Max-Age: 1000');

$Connect = @mysqli_connect("localhost", "merchant_admin", "}{kTftfu1449", "merchant_db");

if ($_POST) {
    /* Getting file name */
    $filename = $_FILES['file']['name'];

    /* Location */
    $location = "sign_img/" . $filename;
    $uploadOk = 1;
    $imageFileType = pathinfo($location, PATHINFO_EXTENSION);


    /* Upload file */

    $Result1 = mysqli_query($Connect, $insertSQL);
    if (move_uploaded_file($_FILES['file']['tmp_name'], $location)) {
        echo $location;
    } else {
        echo 0;
    }
}
