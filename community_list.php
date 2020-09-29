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
<?php 
    include_once 'database.php';
    include_once 'session.php';

    $st = 0;
    $query = "SELECT * FROM communities WHERE user_id=?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$_SESSION['user_id']]);
    echo '<h4 class="mt-5 text-center">Your Communities</h4>';
    echo '<div class="container mt-5"><div class="row"><div class="col-4"><a href="profile.php"><button type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button></a></div><div class="col-4 text-center">';
    if($stmt->rowCount() > 0) {
        while($st < $stmt->rowCount()) {
            $community = $stmt->fetch();
            echo '<img src="community-uploads/' . $community['id'] . "/" . $community['icon'] . '" class="img-fluid img-thumbnail" width="64" height="64"><a href="community_edit.php?id='. $community['id'] .'" class=""><h5 class="">' . $community['name'] . '</h5></a><p class="text-muted mb-5">' . $community['title'] . '</p>';
            $st++;
        }
    } else {
        echo 'You have no communities';
    }
    echo '</div><div class="col-4"></div></div></div>';

    include_once 'footer.php';
?>