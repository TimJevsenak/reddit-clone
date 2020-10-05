<?php 
    include_once 'header.php';
    include_once 'database.php';
    include_once 'session.php';
    $passkey = $_GET['passkey'];

    $query = "SELECT * FROM users WHERE passkey=?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$passkey]);

    if($stmt->rowCount()==1){
        $user = $stmt->fetch();
        $query = "UPDATE users SET verified=? WHERE vkey=?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([1,$passkey]);

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
                        text: "Password changed!",
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
                        text: "Unable to change password!",
                    }).then(function() {
                        window.location = "index.php";
                    });

                    </script>
                    ';
    }
?>