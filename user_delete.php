<?php 
    include_once 'header.php';
    include_once 'database.php';
    include_once 'session.php';

    $id = $_GET['id'];
    if(!isset($id)){
        header('location: index.php');
    }
    $st = 0;
    $st2 = 0;
    $st3 = 0;

    if($_SESSION['admin']){
        $query = "DELETE FROM comment_votes WHERE user_id=?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$id]);

        $query = "DELETE FROM comments WHERE user_id=?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$id]);

        $query = "DELETE FROM post_votes WHERE user_id=?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$id]);

        $query = "DELETE FROM posts WHERE user_id=?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$id]);

        $query = "DELETE FROM subscriptions WHERE user_id=?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$id]);

        $query = "DELETE FROM communities WHERE user_id=?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$id]);

        $query = "DELETE FROM users WHERE id=?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$id]);

        array_map('unlink', glob("user-uploads/$id/*.*"));
        rmdir("user-uploads/$id");

        echo '
        <script type="text/javascript">

        Swal.fire({
            icon: "success",
            text: "User deleted!",
        }).then(function() {
            window.location = "admin.php";
        });

        </script>
        ';
    }
    else{
        header('location: index.php');
    }
?>