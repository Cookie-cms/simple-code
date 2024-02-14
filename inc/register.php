<?php
error_reporting(E_ALL);
ini_set('display_errors', true);
// require_once $_SERVER['DOCUMENT_ROOT'] . "/define.php";

require_once $_SERVER['DOCUMENT_ROOT'] . "/inc/dbconn.php";
// require_once "dbconn.php"; 
// session_start(); 

function validate($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['re_password'])) {
    $username = validate($_POST['username']);
    $pass = validate($_POST['password']);
    $re_pass = validate($_POST['re_password']);

    if (strlen($username) < 4 || !preg_match('/^[A-Za-z0-9_]+$/', $username)) {
        echo "Username should be at least 4 characters long and contain only English keyboard characters.";
        exit();
    }

    if ($pass !== $re_pass) {
        echo "Passwords do not match.";
        exit();
    }

    $uuid = vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex(random_bytes(16)), 4)); // Generate a random UUID

    $hashed_password = password_hash($pass, PASSWORD_BCRYPT);

    try {
        $stmt = $conn->prepare("SELECT * FROM users WHERE username=:username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo "The username is taken, please choose another.";
            exit();
        } else {
            $stmt = $conn->prepare("INSERT INTO users (uuid, username, password) VALUES (:uuid, :username, :pass)");
            $stmt->bindParam(':uuid', $uuid);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':pass', $hashed_password);
            $stmt->execute();

            $user = [
                'id' => $conn->lastInsertId(),
                'uuid' => $uuid
            ];

            if ($user) {
                session_start();
                $_SESSION['id'] = $user['id'];
                $_SESSION['uuid'] = $user['uuid'];

                // $defaultSkinPath = $_SERVER['DOCUMENT_ROOT'] . "/templates/bootstrap/assets/default.png";
                $defaultSkinPath = $_SERVER['DOCUMENT_ROOT'] . "/uploads/skins/default.png";
                
                $uploadDirectory = $_SERVER['DOCUMENT_ROOT'] . "/uploads/skins/";
                $destinationFileName = $uploadDirectory . $user['uuid'] . ".png";

                if (file_exists($defaultSkinPath) && copy($defaultSkinPath, $destinationFileName)) {
                    $home = "/home.php";
                    header("Location: /home.php");
                    exit();
                } else {
                    echo "Failed to copy the default skin to the user's directory.";
                    echo $defaultSkinPath;
                    exit();
                }
            } else {
                echo "Failed to fetch user data.";
                exit();
            }
        }
    } catch (PDOException $e) {
        echo "An error occurred during registration. Please try again later.";
        error_log("PDOException: " . $e->getMessage(), 0);
        exit();
    }
} else {
    echo "Form data incomplete.";
    echo$defaultSkinPath;
    exit();
}
?>