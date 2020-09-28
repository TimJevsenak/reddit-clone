<?php
    include_once 'header.php';
    include_once 'session.php';
    include_once 'database.php';

    $id = $_GET['id'];

    $query = "SELECT * FROM communities WHERE id=?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$id]);
    $community = $stmt->fetch();
    echo $community['name']. $community['title'];
?>