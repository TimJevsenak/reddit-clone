<?php 
    include_once 'database.php';
    include_once 'session.php';

    $name=$_POST['name'];
    $description=$_POST['description'];
    $title=$_POST['title'];
    $icon=$_FILES["image"]["name"];

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

            header("refresh:2;url=profile.php");
        }
        else{
            echo 'No file was uploaded';

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

            header("refresh:5;url=profile.php");
        }
    }
    else{
        echo 'Name already taken.';
        header('refresh:5;url=profile.php');
    }
?>