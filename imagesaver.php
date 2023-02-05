<?php include_once 'generalfunctions.php';
    include_once 'data/dbConnection.php';

function generateImagePath($imageId, $image){
    $partialServerPath = 'resources/img/rentable/';

    $uploadedFileName = $image['name'];

    $fileCompositions = explode('.', $uploadedFileName);
    $fileExt = strtolower(end($fileCompositions));

    return $partialServerPath . $imageId . '.' . $fileExt;
}

function saveImage($imagePath, $image){
    $targetFile = '/home/fwlyf2/public_html/beadando/' . $imagePath;

    return move_uploaded_file($image['tmp_name'], $targetFile);
}