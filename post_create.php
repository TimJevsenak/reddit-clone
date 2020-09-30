<?php
include_once './session.php';
include_once './database.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>read-it</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="siteIcons/logo.jpg" type="png" sizes="16x16">
    <script src="https://kit.fontawesome.com/9546f008dc.js" crossorigin="anonymous"></script>
    <script src="icons.js" defer></script>
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-4 mt-5">
        <a href="profile.php"><button type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button></a>
        </div>
        <div class="col-4 my-5 text-right">
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
                <div class="form-group">
                    <select name="community_id" class="form-control">
                    <?php 
                        $st = 0;

                        $query3 = "SELECT c.id, c.name FROM communities c INNER JOIN subscriptions s ON c.id=s.community_id INNER JOIN users u ON u.id=s.user_id WHERE u.id=?";
                        $stmt = $pdo->prepare($query3);
                        $stmt->execute([$_SESSION['user_id']]);

                        while($st < $stmt->rowCount()) {
                            $community = $stmt->fetch();
                            echo '<option value="' . $community['id'] . '"><span class="text-muted">r</span>/' . $community['name'] . "</option>";
                            $st++;
                        }
                        ?>
                    </select>
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