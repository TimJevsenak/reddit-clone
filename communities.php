<?php 
    include_once 'header.php';
    include_once 'database.php';
    include_once 'session.php';

    $st = 0;
    $query = "SELECT * FROM communities ORDER BY RAND()";
    $stmt = $pdo->prepare($query);
    $stmt->execute();

    echo '<div class="container mt-5"><div class="row"><div class="col-3"></div><div class="col-6">';
    if($stmt->rowCount() > 0) {
        while($st < $stmt->rowCount()) {
            $community = $stmt->fetch();
            $date = new \DateTime($community['dateCreated']);
            $datum = $date->format('d/m/Y');
            echo '<img src="community-uploads/' . $community['id'] . "/" . $community['icon'] . '" class="img-fluid img-thumbnail" width="64" height="64"><a href="community_show.php?id='. $community['id'] .'" class=""><h5 class="">' . $community['name'] . '</h5></a><p class="text-muted mb-0">' . $community['title'] . '</p><div class="text-right mb-5"><p class="text-muted">' . $datum . '</p></div>';
            $st++;
        }
    } else {
        echo 'No communities to display.';
    }
    echo '</div><div class="col-3"></div></div></div>';

    include_once 'footer.php';
?>