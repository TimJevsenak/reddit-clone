<?php
    include_once 'header.php';
    include_once 'database.php';
    include_once 'session.php';

    $email = $_POST['email'];

    $passkey = md5(time().$username);

    $query = "INSERT INTO users (passkey) WHERE email=?"
            . "VALUES (?)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$passkey, $email]);

    $to = $email;
    $subject = "Reset Password!";
    $message = "<a href='https://timjevsenak.eu/verify_password_reset.php?passkey=$passkey'>Reset password</a>";

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
        text: "Email sent!",
    }).then(function() {
        window.location = "thankyou_password_reset.php";
    });

    </script>
    ';
    }
?>