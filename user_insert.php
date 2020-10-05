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
            
            if(strlen($password) >= 5){
                $vkey = md5(time().$username);
            
                $pass = password_hash($password, PASSWORD_DEFAULT);
                
                $query = "INSERT INTO users (username,email,pass,vkey)"
                        . "VALUES (?,?,?,?)";
                $stmt = $pdo->prepare($query);
                $stmt->execute([$username,$email,$pass,$vkey]);

                $query2 = "SELECT * FROM users WHERE email=?";
                $stmt = $pdo->prepare($query2);
                $stmt->execute([$email]);

                if ($stmt->rowCount() == 1) {
                    $user = $stmt->fetch();
                }

                mkdir("user-uploads/".$user['id']);

                //send Email
                $to = $email;
                $subject = "Email verification";
                $message = "<a href='https://timjevsenak.eu/verify_email.php?vkey=$vkey'>Register account</a>";

                $fromserver = "noreply@timjevsenak.eu"; 
                require("PHPMailer/PHPMailerAutoload.php");
                $mail = new PHPMailer();
                $mail->IsSMTP();
                $mail->Host = "	timjevsenak.eu"; // Enter your host here
                $mail->SMTPAuth = true;
                $mail->Username = "noreply@timjevsenak.eu"; // Enter your email here
                $mail->Password = "9ZHgzWq5;1m#"; //Enter your password here
                $mail->Port = 25;
                $mail->IsHTML(true);
                $mail->From = "noreply@yourwebsite.com";
                $mail->FromName = "Read-it";
                $mail->Sender = $fromserver; // indicates ReturnPath header
                $mail->Subject = $subject;
                $mail->Body = $message;
                $mail->AddAddress($to);
                if(!$mail->Send()){
                echo "Mailer Error: " . $mail->ErrorInfo;
                }else{
                echo '
                <script type="text/javascript">

                Swal.fire({
                    icon: "success",
                    text: "Account added. Please verify your email address.",
                }).then(function() {
                    window.location = "thankyou.php";
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
                    text: "Password too short!",
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