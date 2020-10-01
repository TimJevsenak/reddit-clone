<?php 
    include_once 'database.php';
    include_once 'session.php';

    $id=$_GET['id'];
    $text = $_POST['text'];

    $query = "INSERT INTO comments (text, post_id, user_id)"
        . "VALUES (?,?,?)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$text, $id, $_SESSION['user_id']]);

        header("refresh:2;url=post_show.php?id=".$id);
?>