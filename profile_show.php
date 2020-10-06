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
    $query = "SELECT * FROM posts WHERE user_id=?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$user['id']]);
    while($st < $stmt->rowCount()){
        $post = $stmt->fetch();
        echo '<h3>'.$.'</h3>';
        $st++;
    }
?>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>
</html>