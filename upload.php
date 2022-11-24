<?php 

$image = $_FILES['upload']['name'];
$tmp_dir = $_FILES['upload']['tmp_name'];
move_uploaded_file($tmp_dir, 'uploads/'.$image);
$response = array( 
    "uploaded" => 1, 
    "fileName" => $image, 
    "url" => $upload_dir['img'].$image 
);
echo json_encode($response);
