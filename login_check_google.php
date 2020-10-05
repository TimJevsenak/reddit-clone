<?php
include_once 'header.php';
include_once './session.php';
include_once './database.php';

$username = $_POST['username'];
$email = $_POST['email'];

$query = "SELECT * FROM users WHERE email=?";
$stmt = $pdo->prepare($query);
$stmt->execute([$email]);

if($stmt->rowCount() == 1){
    $query = "INSERT INTO users (username,email)"
                        . "VALUES (?,?)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$username,$email]);

    $_SESSION['user_id'] = $user['id']; 
    $_SESSION['username'] = $user['username']; 
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