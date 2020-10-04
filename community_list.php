
<?php 
    include_once 'header.php';
    include_once 'database.php';
    include_once 'session.php';
    if(!isset($_SESSION['user_id'])){
        header('location: index.php');
    }

    $st = 0;
    $query = "SELECT * FROM communities WHERE user_id=?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$_SESSION['user_id']]);
    echo '<h4 class="mt-5 text-center">Your Communities</h4>';
    echo '<div class="container mt-4"><div class="row"><div class="col-2"><a href="profile.php"><button type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button></a></div><div class="col-8 text-center">';
    if($stmt->rowCount() > 0) {
        while($st < $stmt->rowCount()) {
            $community = $stmt->fetch();
            echo '<a href="community_delete.php?id=' . $community['id'] . '" class="text-danger">Delete community</a><br><img src="community-uploads/' . $community['id'] . "/" . $community['icon'] . '" class="img-fluid img-thumbnail" width="64" height="64"><a href="community_edit.php?id='. $community['id'] .'" class=""><h5 class="">' . $community['name'] . '</h5></a><p class="text-muted mb-5">' . $community['title'] . '</p>';
            $st++;
        }
    } else {
        echo 'You have no communities';
    }
    echo '</div><div class="col-2"></div></div></div>';

    include_once 'footer.php';
?>