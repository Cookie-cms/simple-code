<?php
error_reporting(E_ALL);
ini_set('display_errors', true);
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . "/inc/dbconn.php";

if (!(isset($_SESSION['id']) && isset($_SESSION['uuid']))) {
    header("Location: login.php");
    exit();
}

$uuid = $_SESSION['uuid'];

try {
    $stmt = $conn->prepare("SELECT username FROM users WHERE uuid = :uuid");
    $stmt->bindParam(':uuid', $uuid);
    $stmt->execute();
    $fetchedUser = $stmt->fetch(PDO::FETCH_ASSOC);
    $playername = $fetchedUser['username'];
} catch (PDOException $e) {
    echo "Database Error: " . $e->getMessage();
} catch (Exception $e) {
    error_log("General Error: " . $e->getMessage());
}
?>
