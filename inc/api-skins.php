<?php
error_reporting(E_ALL);
ini_set('display_errors', true);

require 'SkinViewer2D.class.php';
header("Content-type: image/png");

$show = $_GET['show'];

$baseDir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/skins/';
$capeDir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/capes/';
$skin = empty($_GET['file_name']) ? 'default' : $_GET['file_name'];
$skin = $baseDir . $skin . '.png';

if (!skinViewer2D::isValidSkin($skin)) {
    $skin = $baseDir . 'default.png';
}

if ($show !== 'head') {
    $filePath = $capeDir . $_GET['file_name'] . ".png";
    // echo($filePath);
    if (file_exists($filePath)) {
        $cloak = $filePath;

    } else {
        // The file does not exist
        // Your code for the else case
        $cloak = false;
    }
    // echo($cloak);
    $side = isset($_GET['side']) ? $_GET['side'] : false;

    $img = skinViewer2D::createPreview($skin, $cloak, $side);
} else {
    $img = skinViewer2D::createHead($skin, 64);
}

imagepng($img);
