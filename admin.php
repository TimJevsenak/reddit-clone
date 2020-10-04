<?php
    include_once 'header.php';
    include_once 'database.php';
    include_once 'session.php';
    if(!isset($_SESSION['user_id'])){
        header('location: index.php');
    }
    if(!$_SESSION['admin']){
        header('location: index.php');
    }

?>

<div class="container mt-5">
    <div class="row text-center">
        <div class="col-lg-4">
            <h2>All users</h2>
            <?php 
                $st = 0;
                $query = "SELECT * FROM users WHERE id not in (?) ORDER BY dateCreated DESC";
                $stmt = $pdo->prepare($query);
                $stmt->execute([$_SESSION['user_id']]);
                if($stmt->rowCount() > 0) {
                    while($st < $stmt->rowCount()) {
                        $user = $stmt->fetch();
                        echo '<a href="user_delete.php?id=' . $user['id'] . '" class="text-danger">Delete user</a><br><img src="user-uploads/' . $user['id'] . "/" . $user['avatar'] . '" class="img-fluid img-thumbnail" width="32" height="32" style="border-radius: 50%;"><h5 class="">' . $user['username'] . '</h5></a><p class="text-muted mb-1">' . $user['email'] . '</p><p class="text-muted mb-1">' . $user['displayname'] . '</p><p class="text-muted mb-5" style="overflow: hidden; height: 3rem;">' . $user['description'] . '</p>';
                        $st++;
                    }
                } else {
                    echo 'There are no users yet.';
                }
            ?>
        </div>
        <div class="col-lg-4">
            <h2>All communities</h2>
            <?php 
                $st = 0;
                $query = "SELECT * FROM communities ORDER BY dateCreated DESC";
                $stmt = $pdo->prepare($query);
                $stmt->execute();
                if($stmt->rowCount() > 0) {
                    while($st < $stmt->rowCount()) {
                        $community = $stmt->fetch();
                        echo '<a href="community_delete.php?id=' . $community['id'] . '" class="text-danger">Delete community</a><br><img src="community-uploads/' . $community['id'] . "/" . $community['icon'] . '" class="img-fluid img-thumbnail" width="32" height="32" style="border-radius: 50%;"><h5 class="">' . $community['name'] . '</h5><p class="text-muted mb-5">' . $community['title'] . '</p>';
                        $st++;
                    }
                } else {
                    echo 'There are no communities yet.';
                }
            ?>
        </div>
        <div class="col-lg-4">
            <h2>All posts</h2>
            <?php 
                $st = 0;
                $query = "SELECT * FROM posts ORDER BY date DESC";
                $stmt = $pdo->prepare($query);
                $stmt->execute();
                if($stmt->rowCount() > 0) {
                    while($st < $stmt->rowCount()) {
                        $post = $stmt->fetch();
                        echo '<a href="post_delete.php?id=' . $post['id'] . '" class="text-danger">Delete post</a><br><img src="post-uploads/' . $post['id'] . "/" . $post['image'] . '" class="img-fluid img-thumbnail" width="64" height="64"><a href="post_show.php?id=' . $post['id'] . '"><h5 class="">' . $post['title'] . '</h5></a><p class="text-muted mb-5" style="overflow: hidden; height: 3rem;">' . $post['post'] . '</p>';
                        $st++;
                    }
                } else {
                    echo 'There are no posts yet.';
                }
            ?>
        </div>
    </div>
</div>

<?php
    include_once 'footer.php';
?>