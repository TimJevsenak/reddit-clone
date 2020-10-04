<?php 
    include_once 'header.php';
    include_once 'database.php';
    include_once 'session.php';
    if(!isset($_SESSION['user_id'])){
        header('location: index.php');
    }

    $title=$_POST['title'];
    $post=$_POST['post'];
    $image=$_FILES["image"]["name"];
    $community_id = $_POST['community_id'];

    if(empty($title) || empty($post) || empty($community_id))
    {
        header('location: index.php');
    }

    if($image!=""){ 
        $query2 = "INSERT INTO posts (title,post,community_id,image,user_id)"
        . "VALUES (?,?,?,?,?)";
        $stmt = $pdo->prepare($query2);
        $stmt->execute([$title,$post,$community_id,$image,$_SESSION['user_id']]);

        $query3 = "SELECT * FROM posts ORDER BY id DESC LIMIT 1";
        $stmt = $pdo->prepare($query3);
        $stmt->execute([]);

        if ($stmt->rowCount() == 1) {
            $post = $stmt->fetch();
        }
        $_SESSION['post_id']=$post['id'];

        mkdir("post-uploads/".$post['id']);

        include_once 'post_file_upload.php';

        echo '
            <script type="text/javascript">

            Swal.fire({
                icon: "success",
                text: "Post created!",
            }).then(function() {
                window.location = "post_list.php";
            });

            </script>
            ';
    }
    else{

        $query2 = "INSERT INTO posts (title,post,community_id,user_id)"
        . "VALUES (?,?,?,?)";
        $stmt = $pdo->prepare($query2);
        $stmt->execute([$title,$post,$community_id,$_SESSION['user_id']]);

        $query3 = "SELECT * FROM posts ORDER BY id DESC LIMIT 1";
        $stmt = $pdo->prepare($query3);
        $stmt->execute([]);

        if ($stmt->rowCount() == 1) {
            $post = $stmt->fetch();
        }

        mkdir("post-uploads/".$post['id']);

        echo '
            <script type="text/javascript">

            Swal.fire({
                icon: "success",
                text: "Post created!",
            }).then(function() {
                window.location = "post_list.php";
            });

            </script>
            ';
    }
?>