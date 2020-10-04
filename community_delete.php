<?php
    include_once 'database.php';
    include_once 'session.php';
    include_once 'header.php';

    $id = $_GET['id'];
    $st = 0;
    $st2 = 0;

    $query = "SELECT * FROM communities WHERE id=?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$id]);
    $community = $stmt->fetch();
if($community['user_id'] == $_SESSION['user_id']){

    $query = "SELECT * FROM posts WHERE community_id=?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$id]);
    if($stmt->rowCount() > 0) {
        while($st < $stmt->rowCount()) {
            $post=$stmt->fetch();
            $query2 = "DELETE FROM post_votes WHERE post_id=?";
            $stmt2 = $pdo->prepare($query2);
            $stmt2->execute([$post['id']]);
                $query3 = "SELECT * FROM comments WHERE post_id=?";
                $stmt3 = $pdo->prepare($query3);
                $stmt3->execute([$post['id']]);
                if($stmt->rowCount() > 0) {
                    while($st2 < $stmt3->rowCount()) {
                        $comment=$stmt3->fetch();
                        $query4 = "DELETE FROM comment_votes WHERE comment_id=?";
                        $stmt4 = $pdo->prepare($query4);
                        $stmt4->execute([$comment['id']]);
                        $st2++;
                    }
                }
                $query3 = "DELETE FROM comments WHERE post_id=?";
                $stmt3 = $pdo->prepare($query3);
                $stmt3->execute([$post['id']]);
            $st++;
        }
    }
    $query = "DELETE FROM posts WHERE community_id=?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$id]);

    $query = "DELETE FROM subscriptions WHERE community_id=?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$id]);

    $query = "DELETE FROM communities WHERE id=?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$id]);

    array_map('unlink', glob("community-uploads/$id/*.*"));
    rmdir("community-uploads/$id");

    echo '
            <script type="text/javascript">

            Swal.fire({
                icon: "success",
                text: "Community deleted!",
            }).then(function() {
                window.location = "community_list.php";
            });

            </script>
            ';
}
else{
    header('location: index.php');
}
?>