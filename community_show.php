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

    $query = "SELECT * FROM subscriptions WHERE community_id=? AND user_id=?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$id, $_SESSION['user_id']]);
    if($stmt->rowCount() > 0){
        $subed = 1;
    }

    $query = "SELECT * FROM subscriptions WHERE community_id=?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$id]);
    $subs = $stmt->rowCount();
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-2">
             <a href="communities.php"><button type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button></a>
        </div>
        <div class="col-8 text-center">
            <p class="my-2"><img src="community-uploads/<?php echo $community['id'] . "/" . $community['icon']; ?>" class="img-fluid img-thumbnail" width="64" height="64"></p>
            <h2 class="my-2"><?php echo $community['name']; ?></h2>
            <h5 class="mt-5 mb-2"><?php echo $community['title']; ?></h5>
            <p class="my-3"><?php echo $community['description'] ?></p>
        </div>
        <div class="col-2">
            <p class="font-weight-bold">MEMBERS: <?php echo $subs; ?></p>
            <a href="subscription.php?id=<?php echo $id; ?>"><button type="button" class="btn btn-outline-danger" <?php if($subed == 1)echo 'disabled'; ?>><?php if($subed == 1){echo 'JOINED';} else{echo 'JOIN';}  ?></button></a>
        </div>
    </div>
</div>

<?php
    include_once 'footer.php';
?>