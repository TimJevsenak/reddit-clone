<?php 
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password_current = $_POST['password_current'];
    $password_new = $_POST['password_new'];
    $password_new_confirm = $_POST['password_new_confirm'];

    $query = "SELECT * FROM users WHERE email=? AND id=?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$email], [$_SESSION['user_id']]);

    if ($stmt->rowCount() == 1) {
        $user = $stmt->fetch();
    }

    else{
        header("Location: profile.php");
    }

    if (password_verify($password_current, $user['pass'])) {

    }
?>