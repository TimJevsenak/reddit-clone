<?php 
    include_once 'header.php';
    include_once 'session.php';
    include_once 'database.php';

    $user = $_GET['user'];

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

    <div class="row text-center">
        <div class="col-4"></div>
        <div class="col-lg-4">
            <?php 
                if($user['avatar'] != ""){
                    echo '<img src="user-uploads/'.$user['id'].'/'.$user['avatar'].'"';
                }
            ?>  
            <h3><?php echo $user['username'] ?></h3>
            <h5><?php echo $user['displayname'] ?></h5>
            <small class="text-muted">Maybe send an email: <?php echo $user['email'] ?></small>
            <p><?php echo $user['description'] ?></p>
        </div>
        <div class="col-4"></div>
    </div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>
</html>