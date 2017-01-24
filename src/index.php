<?php

// config
$fileUploadFolder = __DIR__ . DIRECTORY_SEPARATOR . 'uploads';
$postUploadFolder = __DIR__ . DIRECTORY_SEPARATOR . 'post';

if(!file_exists($fileUploadFolder))
    mkdir($fileUploadFolder, 0777, true);

if(!file_exists($postUploadFolder))
    mkdir($postUploadFolder, 0777, true);


// PS! realpath does not work on paths that does not exist
$fileUploadFolder = realpath($fileUploadFolder);
$postUploadFolder = realpath($postUploadFolder);

// Routing
if($_SERVER['REQUEST_URI'] == '/file') {
	$file = $_FILES['file'];
	$hash = sha1_file($file['tmp_name']);

	$newFilename = $fileUploadFolder . DIRECTORY_SEPARATOR . $hash;
	move_uploaded_file($file['tmp_name'], $newFilename);

	header('Content-Type: application/json');
	echo json_encode(array('id' => $hash));
}
else if(preg_match('/^\/createpost(\/.*)?$/', $_SERVER['REQUEST_URI'])) {
	if($_SERVER['REQUEST_METHOD'] === 'POST') {
		$post_data = file_get_contents('php://input');
		$filename = sha1($post_data) . ".html";

		file_put_contents($postUploadFolder . DIRECTORY_SEPARATOR . $filename, $post_data);
		echo '/post/' . $filename;
	}
}
else {
	echo file_get_contents('index.html');
}
