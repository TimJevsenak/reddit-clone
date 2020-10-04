<?php 
    include_once 'database.php';
    include_once 'session.php';
    if(!isset($_SESSION['user_id'])){
        header('location: index.php');
    }

    $id=$_GET['id'];
    $text = $_POST['text'];
    if(empty($id) || empty($text)){
        header('location: index.php');
    }

    $query = "INSERT INTO comments (text, post_id, user_id)"
        . "VALUES (?,?,?)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$text, $id, $_SESSION['user_id']]);

        header("location: post_show.php?id=".$id);
?>