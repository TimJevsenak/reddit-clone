<?php 
    include_once 'header.php';
    include_once 'session.php';
    include_once 'database.php';

    $id = $_GET['id'];
    
    $query = "SELECT * FROM posts WHERE id=?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$id]);
    $post = $stmt->fetch();
?>

    <div class="row mt-5">
        <div class="col-2"></div>
        <div class="col-lg-8 text-center">
            <h2><?php echo $post['title']; ?></h2>
            <?php
                if(isset($post['image'])){ 
                echo '<img src="post-uploads/' . $id . '/' . $post['image'] . '" class="img-fluid" width="80%" height="80%">';
                }
            ?>
            <p class="text-justify mt-4"><?php echo $post['post'] ?></p>
        </div>
        <div class="col-2"></div>
    </div>

<?php 
    include_once 'footer.php';
?>