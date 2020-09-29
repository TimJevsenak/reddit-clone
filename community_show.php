<?php 
    include_once 'database.php';
    include_once 'session.php';
    include_once 'header.php';

    $id = $_GET['id'];
    
    $query = "SELECT * FROM communities WHERE id=?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$id]);
    $community = $stmt->fetch();
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-2 mt-5">
             <a href="communities.php"><button type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button></a>
        </div>
        <div class="col-8">
            <h2 class="my-2 text-center"><?php echo $community['name']; ?></h2>
        </div>
        <div class="col-2"></div>
    </div>
</div>

<?php
    include_once 'footer.php';
?>