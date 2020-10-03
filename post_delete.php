<?php
    include_once 'database.php';
    include_once 'session.php';

    $id = $_GET['id'];
    $st = 0;

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

    header('location: post_list.php');

?>