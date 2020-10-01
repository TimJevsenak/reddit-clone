<?php
    include_once 'database.php';
    include_once 'session.php';

    $id=$_GET['id'];
    $upvote=$_GET['upvote'];

    $query = "SELECT * FROM post_votes WHERE post_id=? AND user_id=?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$id, $_SESSION['user_id']]);

    if($stmt->rowCount() == 0) {
        $query = "INSERT INTO post_votes (post_id, user_id, upvote)"
        . "VALUES (?,?,?)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$id, $_SESSION['user_id'], $upvote]);

        header('location: index.php');
    }
    else{
        $query = "DELETE FROM post_votes WHERE post_id=? AND user_id=?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$id, $_SESSION['user_id']]);

        $query2 = "INSERT INTO post_votes (post_id, user_id, upvote)"
        . "VALUES (?,?,?)";
        $stmt = $pdo->prepare($query2);
        $stmt->execute([$id, $_SESSION['user_id'], $upvote]);

        header('location: index.php');
    }
?>