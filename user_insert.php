<?php
include_once 'header.php';
include_once 'database.php';
include_once 'session.php';

$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$password_confirm = $_POST['password_confirm'];

$query = "SELECT * FROM users WHERE email=?";
$stmt = $pdo->prepare($query);
$stmt->execute([$email]);

if($stmt->rowCount() == 0){
    $query = "SELECT * FROM users WHERE username=?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$username]);
    if($stmt->rowCount() == 0){

        if (!empty($username)
                && !empty($email) && !empty($password)
                && ($password == $password_confirm)) {
            
            if(strlen($password) > 5){
            
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
                
                echo '
                    <script type="text/javascript">

                    Swal.fire({
                        icon: "success",
                        text: "Account added!",
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
                    text: "Password to short!",
                }).then(function() {
                    window.location = "register.php";
                });

                </script>
                ';
            }
        }
        else {
            echo '
                <script type="text/javascript">

                Swal.fire({
                    icon: "error",
                    text: "Make sure that both passwords match!",
                }).then(function() {
                    window.location = "register.php";
                });

                </script>
                ';
        }
    }
    else{
        echo '
            <script type="text/javascript">

            Swal.fire({
                icon: "error",
                text: "A user with that username already exists!",
            }).then(function() {
                window.location = "register.php";
            });

            </script>
            ';
    }
}
else{
    echo '
            <script type="text/javascript">

            Swal.fire({
                icon: "error",
                text: "A user with that email already exists!",
            }).then(function() {
                window.location = "register.php";
            });

            </script>
            ';
}
?>