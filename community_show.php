<?php 
    include_once 'header.php';
    include_once 'database.php';
    include_once 'session.php';

    $query = "SELECT * FROM communities WHERE user_id=?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$_SESSION['user_id']]);

    if($stmt->rowCount() > 0) {
        while($result = $stmt->fetchObject()) {
           print_r($result);
        }
    } else {
        echo 'You have no communities';
    }
?>