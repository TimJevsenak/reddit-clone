<?php 
    include_once 'header.php';
    include_once 'database.php';
    include_once 'session.php';
    if(!isset($_SESSION['user_id'])){
        header('location: index.php');
    }

    $st = 0;
    $query = "SELECT * FROM posts WHERE user_id=?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$_SESSION['user_id']]);
    echo '<h4 class="mt-5 text-center">Your Posts</h4>';
    echo '<div class="container mt-4"><div class="row"><div class="col-2"><a href="profile.php"><button type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button></a></div><div class="col-8 text-center">';
    if($stmt->rowCount() > 0) {
        while($st < $stmt->rowCount()) {
            $post = $stmt->fetch();
            echo '<a href="post_delete.php?id=' . $post['id'] . '" class="text-danger">Delete post</a><a href="post_edit.php?id='. $post['id'] .'" class=""><h5 class="">' . $post['title'] . '</h5></a><p class="text-muted mt-1" style="overflow: hidden; height: 3rem;">' . $post['post'] . '</p><img src="post-uploads/' . $post['id'] . "/" . $post['image'] . '" class="img-fluid mb-5" width="128" height="128"><br>';
            $st++;
        }
    } else {
        echo 'You have no posts.';
    }
    echo '</div><div class="col-2"></div></div></div>';

    include_once 'footer.php';
?>