<?php 
// error_reporting(E_ALL);
// ini_set('display_errors', true);
session_start(); 
// require $_SERVER['DOCUMENT_ROOT'] . "/core/inc/mysql.php";
require_once "dbconn.php"; 
if (isset($_POST['username']) && isset($_POST['password'])) {

    function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $username = validate($_POST['username']);
    $password = validate($_POST['password']);

    echo "Received Username: " . $username . "<br>";
    echo "Received Password: " . $password . "<br>";

    try {
        $stmt = $conn->prepare("SELECT * FROM users WHERE BINARY username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
    
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // Debug: Output fetched user data
        // echo "Fetched User Data: ";
        // var_dump($user); // 

        if ($user && password_verify($password, $user['password']) && $user['username'] === $username) {
            var_dump($user); // Placed here to dump the user data
            $_SESSION['id'] = $user['id'];
            $_SESSION['uuid'] = $user['uuid'];
            // echo "Session created!";
            
            $home = "/home.php";
            header("Location: $home");
            var_dump($user);
            // exit();
        } else {
            echo "Incorrect User name or password";
            // Redirect or handle incorrect login attempt here
        }
    } catch(PDOException $e) {
        // Output detailed error information for debugging
        echo "Error: " . $e->getMessage();
        // Log the error to a file or error tracking system for further investigation
        // You can use error_log or a dedicated logging library
        error_log("Database Error: " . $e->getMessage(), 0);
        // Redirect to an error page or display a generic error message for the user
        header("Location: error.php");
        exit();
    }
} else {
    // Handling if username or password is not set in POST data
    echo "Error: Username or password not provided";
    // Log this error as well for further investigation
    error_log("Username or password not provided", 0);
    // Redirect to an error page or display a generic error message for the user
    header("Location: error.php");
    exit();
}
?>