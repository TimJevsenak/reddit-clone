<?php 
    include_once 'database.php';
    include_once 'session.php';
    include_once 'header.php';

    $id = $_GET['id'];
    $subs = 0;
    $subed = 0;
    
    $query = "SELECT * FROM communities WHERE id=?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$id]);
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
        $join = 'JOIN';
    }
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-2">
            <?php 
                if(isset($_SESSION['user_id'])){
                    echo '<a href="communities.php"><button type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button></a>
                    <a href="index.php" style="color: black;"><i class="fas fa-home-lg-alt"></i></a>';
                }
            ?>
        </div>
        <div class="col-8 text-center">
            <p class="my-2"><img src="community-uploads/<?php echo $community['id'] . "/" . $community['icon']; ?>" class="img-fluid img-thumbnail" width="64" height="64"></p>
            <h2 class="my-2"><?php echo $community['name']; ?></h2>
            <h5 class="mt-5 mb-2"><?php echo $community['title']; ?></h5>
            <p class="my-3"><?php echo $community['description'] ?></p>
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