<?php
include_once 'header.php';
include_once './session.php';
include_once './database.php';

$username = $_POST['username'];
$email = $_POST['email'];
$password = md5(time().$username);
$pass = password_hash($password, PASSWORD_DEFAULT);

$query = "SELECT * FROM users WHERE email=?";
$stmt = $pdo->prepare($query);
$stmt->execute([$email]);

if($stmt->rowCount() == 0){
    $query = "INSERT INTO users (username,email,pass,verified)"
                        . "VALUES (?,?,?,1)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$username,$email,$pass]);

    $query = "SELECT * FROM users WHERE email=?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$email]);

    $user = $stmt->fetch();

    mkdir("user-uploads/".$user['id']);

    $_SESSION['user_id'] = $user['id']; 
    $_SESSION['username'] = $user['username']; 
    $_SESSION['pass'] = $password; 
    $_SESSION['email'] = $user['email'];
    $_SESSION['displayname'] = $user['displayname'];
    $_SESSION['description'] = $user['description'];
    $_SESSION['avatar'] = $user['avatar'];
    $_SESSION['admin'] = $user['admin'];

    echo '
    <script type="text/javascript">

    Swal.fire({
        icon: "success",
        text: "Successfully signed in!",
    }).then(function() {
        window.location = "index.php";
    });

    </script>
    ';
}
else{
    echo '
    <script type="text/javascript">

    Swal.fire({
        icon: "error",
        text: "A user with that username already exists!",
    }).then(function() {
        window.location = "login.php";
    });

    </script>
    ';
}
?>