<?php
include_once './session.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Reddit-clone</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="icon" href="siteIcons/reddit.png" type="png" sizes="16x16">
    <script src="https://kit.fontawesome.com/9546f008dc.js" crossorigin="anonymous"></script>
    <script src="icons.js" defer></script>
</head>
<body>

<?php 
    $query = "SELECT * FROM users WHERE id=?";
    $stmt = $pdo->prepare($query);
    $stmt->execute($_SESSION['user_id']);
    if ($stmt->rowCount() == 1) 
    {
        $user = $stmt->fetch();
    }
?>

<div class="container">
    <div class="row">
        <div class="col-4"></div>
        <div class="col-4 my-5">
            <form class="form-signin" action="user_update.php" method="post">
                <h1 class="h2 my-4 font-weight-normal text-center">Sign Up</h1>
                <label for="inputEmail" class="sr-only">Email address</label>
                <input name="email" type="email" id="inputEmail" class="form-control my-1" placeholder="Email address" value="" required="" autofocus="">
                <label for="inputUsername" class="sr-only">Username</label>
                <input name="username" type="text" id="inputUsername" class="form-control my-1" placeholder="Username" required="">
                <label for="inputPassword" class="sr-only">Password</label>
                <input name="password" type="password" id="inputPassword" class="form-control my-1" placeholder="Password" required="">
                <label for="inputPasswordConfirm" class="sr-only">Confirm password</label>
                <input name="password_confirm" type="password" id="inputPasswordConfirm" class="form-control my-1" placeholder="Confirm password" required="">
                <div class="checkbox my-3 text-center">
                <label>
                <input type="checkbox" value="remember-me"> Remember me
                </label>
                </div>
                <div class="text-center">
                    <button class="btn btn-success" type="submit">Sign Up</button>
                </div>
            </form>
        </div>
        <div class="col-4"></div>
    </div>
</div>

<?php 
include_once './footer.php';
?>