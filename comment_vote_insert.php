<?php
    include_once 'database.php';
    include_once 'session.php';

    $id=$_GET['id'];
    $pid=$_GET['pid'];
    $upvote=$_GET['upvote'];

    if(isset($_SESSION['user_id'])){

        $query = "SELECT * FROM comment_votes WHERE comment_id=? AND user_id=?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$id, $_SESSION['user_id']]);

        if($stmt->rowCount() == 0) {
            $query = "INSERT INTO comment_votes (comment_id, user_id, upvote)"
            . "VALUES (?,?,?)";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$id, $_SESSION['user_id'], $upvote]);

            header('location: post_show.php?id='.$pid.'#'.$id);
        }
        else{
            $query = "DELETE FROM comment_votes WHERE comment_id=? AND user_id=?";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$id, $_SESSION['user_id']]);

            $query2 = "INSERT INTO comment_votes (comment_id, user_id, upvote)"
            . "VALUES (?,?,?)";
            $stmt = $pdo->prepare($query2);
            $stmt->execute([$id, $_SESSION['user_id'], $upvote]);

            header('location: post_show.php?id='.$pid.'#'.$id);
        }
    }
    else{
        header('location: post_show.php?id='.$pid.'#'.$id);
    }
?>