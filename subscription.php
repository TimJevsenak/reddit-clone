<?php 
    include_once 'database.php';
    include_once 'session.php';

    $community_id = $_GET['id'];
    $user_id = $_SESSION['user_id'];

    $query = "INSERT INTO subscriptions (community_id, user_id) VALUES(?, ?)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$community_id, $user_id]);

    header('location: community_show.php?id=' . $community_id);
?>