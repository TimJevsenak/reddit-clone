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
        $query = "SELECT * FROM communities WHERE user_id=?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$id]);
        $query2 = "SELECT * FROM posts WHERE user_id=?";
        $stmt2 = $pdo->prepare($query2);
        $stmt2->execute([$id]);
        
        if($stmt->rowCount() == 0 && $stmt->rowCount() == 0){

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
            echo '
        <script type="text/javascript">

        Swal.fire({
            icon: "error",
            text: "Cant delete user. Please make sure thaht all posts & communities of the uer are deleted!",
        }).then(function() {
            window.location = "admin.php";
        });

        </script>
        ';
        }
        
    }
    else{
        header('location: index.php');
    }
?>