<?php 
    include_once 'header.php';
    include_once 'database.php';
    include_once 'session.php';
    $vkey = $_GET['vkey'];

    $query = "SELECT * FROM users WHERE vkey=?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$vkey]);

    if($stmt->rowCount()==1){
        $user = $stmt->fetch();
        $query = "UPDATE users SET verified=? WHERE vkey=?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([1,$vkey]);

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
                        text: "Email verified!",
                    }).then(function() {
                        window.location = "index.php";
                    });

                    </script>
                    ';
    }
    else{
        $query = "DELETE FROM users WHERE vkey=?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$vkey]);
        echo '
                    <script type="text/javascript">

                    Swal.fire({
                        icon: "error",
                        text: "Unable to verify account!",
                    }).then(function() {
                        window.location = "index.php";
                    });

                    </script>
                    ';
    }
?>