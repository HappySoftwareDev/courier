<?php

// Set new file name
$new_image_name = "newimage_" . mt_rand() . ".jpg";

// upload file
move_uploaded_file($_FILES["file"]["tmp_name"], 'proof_img/' . $new_image_name);
echo $new_image_name;


