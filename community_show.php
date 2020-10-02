<?php 
    include_once 'database.php';
    include_once 'session.php';
    include_once 'header.php';

    $id = $_GET['id'];
    $subs = 0;
    $subed = 0;
    $upvotes=0;
    $downvotes=0;
    $votes=0;
    $color="";

    $query = "SELECT * FROM communities WHERE id=?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$id]);
    if($stmt->rowCount()!=1){
        header('location: index.php');
    }
    
    $community = $stmt->fetch();

    if(isset($_SESSION['user_id'])){
        $query = "SELECT * FROM subscriptions WHERE community_id=? AND user_id=?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$id, $_SESSION['user_id']]);
        if($stmt->rowCount() > 0){
            $subed = 1;
        }
    }

    $query = "SELECT * FROM subscriptions WHERE community_id=?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$id]);
    $subs = $stmt->rowCount();

    if($subed == 1){
        $disabled = 'disabled';
        $join = 'JOINED';
    }
    else{
        $disabled = '';
        $join = 'JOIN';
    }
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
      
      $st = 0;
      
      $query = "SELECT DISTINCT p.id, p.title, p.post, p.image, p.date, p.community_id, c.name, c.icon, u.username
       FROM posts p INNER JOIN communities c ON p.community_id=c.id INNER JOIN subscriptions s ON s.community_id=c.id INNER JOIN users u ON p.user_id=u.id
       WHERE s.community_id=?
       ORDER BY p.date DESC";
      $stmt = $pdo->prepare($query);
      $stmt->execute([$id]);
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-2">
            <?php 
                if(isset($_SESSION['user_id'])){
                    echo '<a href="communities.php"><button type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button></a>';
                }
            ?>
        </div>
        <div class="col-8 text-center">
            <p class="my-2"><img src="community-uploads/<?php echo $community['id'] . "/" . $community['icon']; ?>" class="img-fluid img-thumbnail" width="64" height="64"></p>
            <h2 class="my-2"><?php echo $community['name']; ?></h2>
            <h5 class="mt-5 mb-2"><?php echo $community['title']; ?></h5>
            <p class="my-3"><?php echo $community['description'] ?></p>
            <h3 class="my-5">Posts</h3>
            <?php 
                if($stmt->rowCount() > 0) {
                    while($st < $stmt->rowCount()) {
                        $post = $stmt->fetch();
                        $date = time_elapsed_string($post['date']);

                        $query2 = "SELECT * FROM post_votes WHERE post_id=? AND upvote=?";
                        $stmt2 = $pdo->prepare($query2);
                        $stmt2->execute([$post['id'],1]);
                        $upvotes = $stmt2->rowCount();

                        $query2 = "SELECT * FROM post_votes WHERE post_id=? AND upvote=?";
                        $stmt2 = $pdo->prepare($query2);
                        $stmt2->execute([$post['id'],0]);
                        $downvotes = $stmt2->rowCount();

                        $votes = $upvotes - $downvotes;
                        if($votes <= 0){
                        $color="text-primary";
                        }
                        else{
                        $color="text-danger";
                        }

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
                                <div class="col-md-3 text-md-right px-4">
                                By <span class="text-muted"> u/</span>' . $post['username'] . '
                                </div>
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
                                </div>
                                <small class="text-muted">' . $date . '</small>
                            </div>
                            </div>
                        </div>
                        </div>';
                        $st++;
                    }
                  } 
                  else {
                        echo '<div class="alert alert-info mt-5" role="alert">
                        This community has no posts yet.
                        </div>';
                    }
            ?>
        </div>
        <div class="col-2">
            <?php
                if(isset($_SESSION['user_id'])){
                echo '<p class="font-weight-bold">MEMBERS:' . $subs . '</p>
                <a href="subscription.php?id=' . $id . '"><button type="button" class="btn btn-outline-danger"' . $disabled . '>' . $join . '</button></a>';
                }
                else {
                    echo '<a href="index.php" style="color: black;"><i class="fas fa-home-lg-alt"></i></a>';
                }
            ?>          
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>
</html>