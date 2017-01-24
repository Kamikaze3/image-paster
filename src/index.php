<?php

// config
$fileUploadFolder = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'uploads';

if(!file_exists($fileUploadFolder))
    mkdir($fileUploadFolder, 0777, true);

// PS! realpath does not work on paths that does not exist
$fileUploadFolder = realpath($fileUploadFolder);

// Routing
if($_SERVER['REQUEST_URI'] == '/file') {
	$file = $_FILES['file'];
	$hash = sha1_file($file['tmp_name']);

	$newFilename = $fileUploadFolder . DIRECTORY_SEPARATOR . $hash;
	move_uploaded_file($file['tmp_name'], $newFilename);

	header('Content-Type: application/json');
	echo json_encode(array('id' => $hash));
}
else if(preg_match('/^\/post(\/.*)?$/', $_SERVER['REQUEST_URI'])) {
	echo "post";

	if($_SERVER['REQUEST_METHOD'] === 'POST') {

	} else {

	}
}
else {
	echo file_get_contents('index.html');
}
