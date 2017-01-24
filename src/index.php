<?php

// config
$fileUploadFolder = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'uploads';

if(!file_exists($fileUploadFolder))
    mkdir($fileUploadFolder, 0777, true);

// PS! realpath does not work on paths that does not exist
$fileUploadFolder = realpath($fileUploadFolder);

// Routing
switch($_SERVER['REQUEST_URI'])
{
	case '/file':
        $file = $_FILES['file'];
        $hash = sha1_file($file['tmp_name']);

        $newFilename = $fileUploadFolder . DIRECTORY_SEPARATOR . $hash;
        move_uploaded_file($file['tmp_name'], $newFilename);

        echo "{id:'$hash'}";
		break;

	default:
		echo file_get_contents('index.html');
}

