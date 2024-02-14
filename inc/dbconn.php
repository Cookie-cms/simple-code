<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/inc/config.php";

try {
   $conn = new PDO("mysql:host=$domain;port=$port;dbname=$name", $user, $pass);
   // Perform database operations using $pdo
   $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
   echo "Connection failed: " . $e->getMessage();
}



?>
