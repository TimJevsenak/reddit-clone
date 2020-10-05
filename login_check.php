<?php
include_once 'header.php';
include_once './session.php';
include_once './database.php';
$email = $_POST['email'];
$pass = $_POST['password'];
if(empty($email) || empty($pass))
    {
        header('location: index.php');
    }
//preverim, če sem prejel podatke
if (!empty($email) && !empty($pass)) {
    //$pass = sha1($pass.$salt);
    
    $query = "SELECT * FROM users WHERE email=?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$email]);
    
    if ($stmt->rowCount() == 1) {
        $user = $stmt->fetch();
        if($user['verified']){
            if (password_verify($pass, $user['pass'])) {
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
                    text: "Successfully loged in!",
                }).then(function() {
                    window.location = "index.php";
                });

                </script>
                ';
                //header("Location: index.php");
                die();
            }
            else{
                echo '
            <script type="text/javascript">

            Swal.fire({
                icon: "error",
                text: "Wrong email or password",
            }).then(function() {
                window.location = "login.php";
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
                text: "Email not verified!",
            }).then(function() {
                window.location = "login.php";
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
                text: "Please sign in whit google or facebook to continue!",
            }).then(function() {
                window.location = "login.php";
            });

            </script>
            ';
    }
}
else{
    header('location: login.php');
}

//header("Location: login.php");
?>