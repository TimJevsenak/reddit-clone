<?php
    include_once 'header.php';
    include_once 'database.php';
    include_once 'session.php';
    if(!isset($_SESSION['user_id'])){
        header('location: index.php');
    }

    $id = $_GET['id'];
    if(!isset($id)){
        header('location: index.php');
    }
    $st = 0;

if($_SESSION['admin']){
    $query = "SELECT * FROM comments WHERE post_id=?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$id]);
    if($stmt->rowCount() > 0) {
        while($st < $stmt->rowCount()) {
            $comment=$stmt->fetch();
            $query2 = "DELETE FROM comment_votes WHERE comment_id=?";
            $stmt2 = $pdo->prepare($query2);
            $stmt2->execute([$comment['id']]);
            $st++;
        }
    }

    $query = "DELETE FROM comments WHERE post_id=?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$id]);

    $query = "DELETE FROM post_votes WHERE post_id=?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$id]);

    $query = "DELETE FROM posts WHERE id=?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$id]);

    array_map('unlink', glob("post-uploads/$id/*.*"));
    rmdir("post-uploads/$id");

    echo '
            <script type="text/javascript">

            Swal.fire({
                icon: "success",
                text: "Post deleted!",
            }).then(function() {
                window.location = "admin.php";
            });

            </script>
            ';
}
else{
    $query = "SELECT * FROM posts WHERE id=?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$id]);
    $post = $stmt->fetch();
    
    $query = "SELECT * FROM communities WHERE id=?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$post['community_id']]);
    $community = $stmt->fetch();

    if($community['user_id'] == $_SESSION['user_id']){

        $query = "SELECT * FROM comments WHERE post_id=?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$id]);
        if($stmt->rowCount() > 0) {
            while($st < $stmt->rowCount()) {
                $comment=$stmt->fetch();
                $query2 = "DELETE FROM comment_votes WHERE comment_id=?";
                $stmt2 = $pdo->prepare($query2);
                $stmt2->execute([$comment['id']]);
                $st++;
            }
        }

        $query = "DELETE FROM comments WHERE post_id=?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$id]);

        $query = "DELETE FROM post_votes WHERE post_id=?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$id]);

        $query = "DELETE FROM posts WHERE id=?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$id]);

        array_map('unlink', glob("post-uploads/$id/*.*"));
        rmdir("post-uploads/$id");

        echo '
                <script type="text/javascript">

                Swal.fire({
                    icon: "success",
                    text: "Post deleted!",
                }).then(function() {
                    window.location = "post_list.php";
                });

                </script>
                ';
    }
    else{
        header('location: index.php');
    }
}
?>