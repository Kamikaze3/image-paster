<?php

// config
$fileUploadFolder = realpath(__DIR__ . '/uploads') . DIRECTORY_SEPARATOR;

#if(!file_exists($fileUploadFolder))
#    mkdir($fileUploadFolder, 0777, true);

// Routing
switch($_SERVER['REQUEST_URI'])
{
	case 'fileupload':
        $file = $_FILES['file'];

        #$originalFilenameExtension = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
        $hash = sha1(file_get_contents($file));

        $newFilename = $fileUploadFolder . $hash;
        $file->move($fileUploadFolder, $hash);

        echo "{id:'$hash'}";
		break;
	default:
		echo file_get_contents('index.html');
}

