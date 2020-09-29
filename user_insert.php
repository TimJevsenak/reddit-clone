<?php
include_once 'database.php';
include_once 'session.php';

$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$password_confirm = $_POST['password_confirm'];
//preverim podatke, da so obvezi vnešeni
if (!empty($username)
        && !empty($email) && !empty($password)
        && ($password == $password_confirm)) {
    
    //$pass = sha1($pass1.$salt);
    $pass = password_hash($password, PASSWORD_DEFAULT);
    
    $query = "INSERT INTO users (username,email,pass)"
            . "VALUES (?,?,?)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$username,$email,$pass]);

    $query2 = "SELECT * FROM users WHERE email=?";
    $stmt = $pdo->prepare($query2);
    $stmt->execute([$email]);

    if ($stmt->rowCount() == 1) {
        $user = $stmt->fetch();
    }
    mkdir("user-uploads/".$user['id']);

    $_SESSION['user_id'] = $user['id']; 
    $_SESSION['username'] = $user['username']; 
    $_SESSION['email'] = $user['email'];
    $_SESSION['displayname'] = $user['displayname'];
    $_SESSION['description'] = $user['description'];
    $_SESSION['avatar'] = $user['avatar'];
    
    header("Location: index.php");
}
else {
    header("Location: registration.php");
}
?>