<?php 
    include_once './database.php';
    include_once './session.php';
    include_once './file_upload.php';

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password_current = $_POST['password_current'];
    $password_new = $_POST['password_new'];
    $password_new_confirm = $_POST['password_new_confirm'];
    $displayname=$_POST['displayName'];
    $descripton=$_POST['description'];
    $avatar=$_FILES["image"]["name"];

    if($password_new == $password_new_confirm)
    {

        $query = "SELECT * FROM users WHERE email=?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$email]);

        if ($stmt->rowCount() == 1) {
            $user = $stmt->fetch();
        }

        else{
            echo 'something wrong 2';
        // header("Location: profile.php");
        }

        if (password_verify($password_current, $user['pass'])) {
            if($password_new != ''){
            $pass = password_hash($password_new, PASSWORD_DEFAULT);
            }
            else{
                $pass = password_hash($password_current, PASSWORD_DEFAULT);
            }

            $query2 = "UPDATE users SET username=?, email=?, pass=?, displayname=?, description=?, avatar=?, dateUpdated=CURRENT_TIMESTAMP WHERE email=?;";
            $stmt = $pdo->prepare($query2);
            $stmt->execute([$username,$email,$pass,$displayname,$descripton,$avatar,$email]);

            $query3 = "SELECT * FROM users WHERE email=?";
            $stmt = $pdo->prepare($query3);
            $stmt->execute([$email]);
            $user2 = $stmt->fetch();

            $_SESSION['user_id'] = $user2['id']; 
            $_SESSION['username'] = $user2['username']; 
            $_SESSION['email'] = $user2['email'];
            $_SESSION['displayname'] = $user2['displayname'];
            $_SESSION['description'] = $user2['description'];
            $_SESSION['avatar'] = $user2['avatar'];
            echo 'succes!';
            header("refresh:10;url=profile.php");
        }
        else{
            echo 'Something went wrong3.';
        }
    }
    else{
        echo 'something wrong 1';
    }
?>