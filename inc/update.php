<?php
error_reporting(E_ALL);
ini_set('display_errors', true);
session_start();
require $_SERVER['DOCUMENT_ROOT'] . "/inc/dbconn.php";

$uuid = $_SESSION['uuid'];


// echo "UUID: $uuid. Permission level: $perm.";

if (isset($_POST['new_username']) && !empty($_POST['new_username'])) {
    $new_username = trim(filter_var($_POST['new_username']));

    // echo "New username: $new_username.";

    $stmt = $conn->prepare("UPDATE users SET username = :username WHERE uuid = :uuid");
    $stmt->bindValue(':username', $new_username);
    $stmt->bindValue(':uuid', $uuid);
    $stmt->execute();

    // echo "Username updated.";
}

if (isset($_POST['new_password']) && !empty($_POST['new_password'])) {
    $new_password = trim($_POST['new_password']);
    $new_password_hashed = password_hash($new_password, PASSWORD_BCRYPT);

    // echo "New password received.";

    $stmt = $conn->prepare("UPDATE users SET password = :password WHERE uuid = :uuid");
    $stmt->bindValue(':password', $new_password_hashed);
    $stmt->bindValue(':uuid', $uuid);
    $stmt->execute();

    // echo "Password updated.";
}

// Handle skin upload
if (isset($_FILES['new_skin']) && !empty($_FILES['new_skin']['name'])) {

  $file = $_FILES['new_skin'];

  $mimeType = getimagesize($file['tmp_name'])['mime'];
  if ($mimeType !== 'image/png') {
      die("Invalid file type. Only PNG allowed.");
  }

  
  $imageName = $uuid . ".png";

  $uploadPath = $_SERVER['DOCUMENT_ROOT'] . "/uploads/skins/" . $imageName;

  if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
      echo "File uploaded successfully. UUID: $uuid";


  } else {
      die("Failed to upload file.");
  }
}

if (isset($_FILES['new_cape']) && !empty($_FILES['new_cape']['name'])) {

  $file = $_FILES['new_cape'];

  $mimeType = getimagesize($file['tmp_name'])['mime'];
  if ($mimeType !== 'image/png') {
      die("Invalid file type. Only PNG allowed.");
  }

  
  $imageName = $uuid . ".png";

  $uploadPath = $_SERVER['DOCUMENT_ROOT'] . "/uploads/capes/" . $imageName;

  if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
      echo "File uploaded successfully. UUID: $uuid";


  } else {
      die("Failed to upload file.");
  }
}
header("Location: /home.php");