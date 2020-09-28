<?php 
    include_once 'header.php';
    include_once 'database.php';
    include_once 'session.php';

    $st = 0;
    $query = "SELECT * FROM communities";
    $stmt = $pdo->prepare($query);
    $stmt->execute();

    echo '<div class="container mt-5"><div class="row"><div class="col-3"></div><div class="col-6 text-center">';
    if($stmt->rowCount() > 0) {
        while($st < $stmt->rowCount()) {
            $community = $stmt->fetch();
            echo '<img src="community-uploads/' . $community['id'] . "/" . $community['icon'] . '" class="img-fluid img-thumbnail" width="64" height="64"><a href="community_show.php?id='. $community['id'] .'" class=""><h5 class="">' . $community['name'] . '</h5></a><p class="text-muted mb-5">' . $community['title'] . '</p>';
            $st++;
        }
    } else {
        echo 'You have no communities';
    }
    echo '</div><div class="col-3"></div></div></div>';

    include_once 'footer.php';
?>