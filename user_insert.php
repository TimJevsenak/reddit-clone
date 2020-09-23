<?php
include_once './database.php';

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
    
    header("Location: login.php");
}
else {
    header("Location: registration.php");
}
?>