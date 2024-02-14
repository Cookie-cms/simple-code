<?php
session_start();

$uuid = $_SESSION['uuid'];
$filename = $_SERVER['DOCUMENT_ROOT'] . "/uploads/capes/" . $uuid . ".png";

if (file_exists($filename)) {
    // Check if the file exists before attempting to remove it
    if (unlink($filename)) {
        echo "File $filename has been successfully removed.";
    } else {
        echo "Error removing the file $filename.";
        // You may want to log the error or handle it differently
    }
} else {
    echo "File $filename does not exist.";
}
header("Location: /home.php");

?>
