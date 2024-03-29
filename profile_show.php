<?php 
    include_once 'header.php';
    include_once 'session.php';
    include_once 'database.php';

    $st = 0;
    $user = $_GET['user'];

    function time_elapsed_string($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);
      
        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;
      
        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }
      
        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
      }

    $query = "SELECT * FROM users WHERE username=?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$user]);
    if($stmt->rowCount()!=1){
        header('location: index.php');
    }
    
    $query = "SELECT * FROM users WHERE username=?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$user]);
    $user = $stmt->fetch();
?>

    <div class="row text-center mt-5">
        <div class="col-4"></div>
        <div class="col-lg-4">
            <?php 
                if($user['avatar'] != ""){
                    echo '<img src="user-uploads/'.$user['id'].'/'.$user['avatar'].'" class="img-fluid img-thumbnail" width="64" height="64"';
                }
            ?>  
            <br>
            <h3><?php echo $user['username'] ?></h3>
            <h5><?php echo $user['displayname'] ?></h5>
            <small class="text-muted">Maybe send an email: <?php echo $user['email'] ?></small>
            <p><?php echo $user['description'] ?></p>
        </div>
        <div class="col-4"></div>
    </div>
<?php

    $query2 = "SELECT * FROM post_votes WHERE post_id=? AND upvote=?";
    $stmt2 = $pdo->prepare($query2);
    $stmt2->execute([$user['id'],1]);
    $upvotes = $stmt2->rowCount();

    $query2 = "SELECT * FROM post_votes WHERE post_id=? AND upvote=?";
    $stmt2 = $pdo->prepare($query2);
    $stmt2->execute([$user['id'],0]);
    $downvotes = $stmt2->rowCount();

    $votes = $upvotes - $downvotes;
    if($votes <= 0){
    $color="text-primary";
    }
    else{
    $color="text-danger";
    }

    $query = "SELECT p.id, p.title, p.post, p.date, p.community_id, p.image, c.name, c.icon FROM posts p INNER JOIN communities c ON c.id=p.community_id WHERE p.user_id=?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$user['id']]);
    echo '<div class="row mt-5"><div class="col-2"></div><div class="col-lg-8">';
    while($st < $stmt->rowCount()){
        $post = $stmt->fetch();
        echo '
        <div id="' . $post['id'] . '" class="mt-5">
        <div class="card mb-4 shadow-sm">
            <div class="card-title my-2">
            <div class="row">
                <div class="col-md-3 text-md-left px-4">
                <img src="community-uploads/' . $post['community_id'] . '/' . $post['icon'] .'" class="img-fluid" width="32" height="32" style="border-radius: 50%;">
                <span class="text-muted">r/</span>' . $post['name'] . '
                </div>
                <div class="col-md-6 text-md-center">
                <h4 class="px-4">' . $post['title'] . '</h4>
                </div>
                <div class="col-md-3"></div>
            </div>
            </div><a href="post_show.php?id='. $post['id'] . '" style="color: black; text-decoration: none;">';
            if($post['image']!=""){
            echo '<img src="post-uploads/' . $post['id'] . '/' . $post['image'] .'" class="img-fluid" width="100%" height="100%">';
            }
            echo '<div class="card-body">
            <p class="card-text" style="overflow: hidden; height: 6rem;">' . $post['post'] . '</p></a>
            <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                <a href="community_show_vote_insert.php?id=' . $post['id'] . '&upvote=1&cid=' . $post['community_id'] . '" class="text-danger" style="text-decoration: none;"><i class="far fa-arrow-square-up fa-2x mx-1"></i></a> <span class="font-weight-bold mx-2 ' . $color . '">' . $votes . '</span>
                <a href="community_show_vote_insert.php?id=' . $post['id'] . '&upvote=0&cid=' . $post['community_id'] . '" class="text-primary" style="text-decoration: none;"><i class="far fa-arrow-square-down mx-1 fa-2x"></i></a>
                <a href="post_show.php?id=' . $post['id'] . '#bottom" class="text-dark ml-5" style="text-decoration: none;"><i class="fal fa-comment-lines fa-2x"></i></a>
                </div>
                <small class="text-muted">' . $date . '</small>
            </div>
            </div>
        </div>
        </div>';
        $st++;
    }
    echo '</div><div class="col-2></div></div>"';
?>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>
</html>