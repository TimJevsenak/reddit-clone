<?php
    include_once 'header.php';
    include_once 'session.php';
    include_once 'database.php';

    $id = $_GET['id'];

    $query = "SELECT * FROM posts WHERE id=?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$id]);
    if($stmt->rowCount()!=1){
        header('location: index.php');
    }
    $post = $stmt->fetch();
?>
<div class="conatainer">
    <div class="row">
        <div class="col-4 mt-5">
            <a href="post_list.php"><button type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button></a>
        </div>
        <div class="col-lg-4 my-5">
        <form class="form-signin" action="post_update.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
            <h1 class="h2 mb-4 font-weight-normal text-center">Change your post</h1>
            <input name="title" type="text" class="form-control my-1" placeholder="Name" value="<?php echo $post['title']; ?>" required="" autofocus="">
            <textarea name="post" class="form-control" id="Textarea" rows="3" placeholder="Post"><?php echo $post['post']; ?></textarea>
            <div class="input-group mt-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default">Image</span>
                </div>
                <input name="image" type="file" id="image" class="form-control-file my-1">
            </div>
            <div class="text-center">
                <img src="post-uploads/<?php echo $id . "/" . $post['image']; ?>" class="img-fluid img-thumbnail" alt="No icon yet" width="192" height="128">
            </div>
            <div class="text-center mt-3">
                <button class="btn btn-success" type="submit" name="submit">Save changes</button>
            </div>
        </form>
        </div>
        <div class="col-4"></div>
    </div>
</div>
<?php include_once 'footer.php'; ?>