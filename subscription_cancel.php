<?php 
    include_once 'database.php';
    include_once 'session.php';
    if(!isset($_SESSION['user_id'])){
        header('location: index.php');
    }

    $community_id = $_GET['id'];
    $user_id = $_SESSION['user_id'];

    $query = "DELETE FROM subscriptions WHERE community_id=? AND user_id=?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$community_id, $user_id]);

    header('location: community_show.php?id=' . $community_id);
?>