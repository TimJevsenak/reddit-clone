<?php
include_once 'header.php';
include_once 'session.php';
include_once 'database.php';

if(!isset($_SESSION['user_id'])){
    header('location: index.php');
}
?>

<div class="container">
    <div class="row">
        <div class="col-4 mt-5">
        <a href="profile.php"><button type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button></a>
        </div>
        <div class="col-lg-4 my-5 text-right">
            <form class="form-signin" action="post_insert.php" method="post" enctype="multipart/form-data">
                <h1 class="h2 mb-4 font-weight-normal text-center">Write a post</h1>
                <input name="title" type="text" class="form-control my-1" placeholder="Title" required="" autofocus="">
                <textarea name="post" class="form-control" id="Textarea" rows="3" placeholder="What's on your mind?" required=""></textarea>
                <div class="input-group my-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-default">Image: </span>
                    </div>
                    <input name="image" type="file" id="image" class="form-control-file my-1">
                </div>
                <div class="form-group text-center">
                    <small class="text-muted">Which community will you post to?</small>
                    <?php 
                        $st = 0;

                        $query3 = "SELECT c.id, c.name FROM communities c INNER JOIN subscriptions s ON c.id=s.community_id INNER JOIN users u ON u.id=s.user_id WHERE u.id=?";
                        $stmt = $pdo->prepare($query3);
                        $stmt->execute([$_SESSION['user_id']]);
                        if($stmt->rowCount() > 0){
                            echo '<select name="community_id" class="form-control" required="">';

                            while($st < $stmt->rowCount()) {
                                $community = $stmt->fetch();
                                echo '<option value="' . $community['id'] . '"><span class="text-muted">r</span>/' . $community['name'] . "</option>";
                                $st++;
                            }
                            echo '</select>';
                        }
                        else{
                            echo '
                            <script type="text/javascript">

                            Swal.fire({
                                icon: "error",
                                text: "You need to subscribe to a community to post!",
                            }).then(function() {
                                window.location = "profile.php?id=";
                            });

                            </script>
                            ';
                        }
                        ?>
                </div>
                <div class="text-center">
                    <button class="btn btn-success" type="submit" name="submit">Post</button>
                </div>
            </form>
        </div>
        <div class="col-4"></div>
    </div>
</div>

<?php 
include_once './footer.php';
?>