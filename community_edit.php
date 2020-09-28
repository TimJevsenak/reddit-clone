<?php
    include_once 'header.php';
    include_once 'session.php';
    include_once 'database.php';

    $id = $_GET['id'];

    $query = "SELECT * FROM communities WHERE id=?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$id]);
    $community = $stmt->fetch();
?>
<div class="conatainer">
    <div class="row">
        <div class="col-4 mt-5">
            <a href="community_list.php"><button type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button></a>
        </div>
        <div class="col-4 my-5">
        <form class="form-signin" action="community_update.php" method="post" enctype="multipart/form-data">
            <h1 class="h2 mb-4 font-weight-normal text-center">Update community</h1>
            <input name="name" type="text" class="form-control my-1" placeholder="Name" value="<?php echo $community['name']; ?>" required="" autofocus="">
            <input name="title" type="text" class="form-control my-1" placeholder="Title" value="<?php echo $community['title']; ?>">
            <textarea name="description" class="form-control" id="Textarea" rows="3" placeholder="Description"><?php echo $_SESSION['description']; ?></textarea>
            <div class="input-group mt-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default">Icon</span>
                </div>
                <input name="image" type="file" id="image" class="form-control-file my-1">
            </div>
            <div class="text-left">
                <img src="community-uploads/<?php echo $id . "/" . $community['icon']; ?>" class="img-fluid img-thumbnail" alt="No icon yet" width="64" height="64">
            </div>
            <div class="text-center mt-3">
                <button class="btn btn-success" type="submit" name="submit">Update</button>
            </div>
        </form>
        </div>
        <div class="col-4"></div>
    </div>
</div>