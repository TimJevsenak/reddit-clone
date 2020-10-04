<?php 
    include_once 'header.php';
    include_once 'database.php';
    include_once 'session.php';
    if(!isset($_SESSION['user_id'])){
        header('location: index.php');
    }

    $name=$_POST['name'];
    $description=$_POST['description'];
    $title=$_POST['title'];
    $icon=$_FILES["image"]["name"];
    if(empty($name) || empty($description) || empty($title) || empty($icon))
    {
        header('location: index.php');
    }

    $query = "SELECT * FROM communities WHERE name=?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$name]);
    if ($stmt->rowCount() == 0) {

        if($icon!=""){ 
            $query2 = "INSERT INTO communities (name,description,title,icon,user_id)"
            . "VALUES (?,?,?,?,?)";
            $stmt = $pdo->prepare($query2);
            $stmt->execute([$name,$description,$title,$icon,$_SESSION['user_id']]);

            $query3 = "SELECT * FROM communities WHERE name=?";
            $stmt = $pdo->prepare($query3);
            $stmt->execute([$name]);

            if ($stmt->rowCount() == 1) {
                $community = $stmt->fetch();
            }
            $_SESSION['community_id']=$community['id'];

            mkdir("community-uploads/".$community['id']);

            include_once 'community_file_upload.php';

            echo '
            <script type="text/javascript">

            Swal.fire({
                icon: "success",
                text: "Successfully created the community!",
            }).then(function() {
                window.location = "community_list.php";
            });

            </script>
            ';
        }
        else{
            $query2 = "INSERT INTO communities (name,description,title,user_id)"
            . "VALUES (?,?,?,?)";
            $stmt = $pdo->prepare($query2);
            $stmt->execute([$name,$description,$title,$_SESSION['user_id']]);

            $query3 = "SELECT * FROM communities WHERE name=?";
            $stmt = $pdo->prepare($query3);
            $stmt->execute([$name]);

            if ($stmt->rowCount() == 1) {
                $community = $stmt->fetch();
            }
            $_SESSION['community_id']=$community['id'];

            mkdir("community-uploads/".$community['id']);

            echo '
            <script type="text/javascript">

            Swal.fire({
                icon: "success",
                text: "Successfully created the community!",
            }).then(function() {
                window.location = "community_list.php";
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
                text: "A community with that name already exists!",
            }).then(function() {
                window.location = "community_create.php";
            });

            </script>
            ';
    }
?>