<?php
include_once './session.php';
include_once './database.php';
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

<div class="container">
    <div class="row">
        <div class="col-4 mt-5">
        <a href="index.php"><button type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button></a>
        </div>
        <div class="col-4 my-5 text-right">
            <form class="form-signin" action="user_update.php" method="post">
                <h1 class="h2 mb-4 font-weight-normal text-center">Update profile</h1>
                <label for="inputEmail" class="sr-only">Email address</label>
                <input name="email" type="email" id="inputEmail" class="form-control my-1" placeholder="Email address" value="<?php echo $_SESSION['email']; ?>" required="" autofocus="">
                <label for="inputUsername" class="sr-only">Username</label>
                <input name="username" type="text" id="inputUsername" class="form-control my-1" placeholder="Username" value="<?php echo $_SESSION['username']; ?>" required="">
                <label for="inputPasswordNew" class="sr-only">Password</label>
                <input name="password_new" type="password" id="inputPasswordNew" class="form-control my-1" placeholder="New password">
                <label for="inputPasswordNewConfirm" class="sr-only">Confirm password</label>
                <input name="password_new_confirm" type="password" id="inputPasswordNewConfirm" class="form-control my-1" placeholder="Confirm new password">
                <label for="inputPassword" class="sr-only">Current password</label>
                <input name="password_current" type="password" id="inputPassword" class="form-control my-1" placeholder="Current password" required="">
                <label for="displayName" class="sr-only">Display name</label>
                <input name="displayName" type="text" id="displayName" class="form-control my-1" placeholder="Display name" value="<?php echo $_SESSION['displayname']; ?>">
                <textarea name="description" class="form-control" id="Textarea" rows="3" placeholder="Description"><?php echo $_SESSION['description']; ?></textarea>
                <label for="avatar" class="sr-only">Avatar</label>
                <input name="avatar" type="file" id="avatar" class="form-control-file my-1">
                <div class="checkbox my-3 text-center">
                <label>
                <input type="checkbox" value="remember-me"> Remember me
                </label>
                </div>
                <div class="text-center">
                    <button class="btn btn-success" type="submit">Update</button>
                </div>
            </form>
        </div>
        <div class="col-4"></div>
    </div>
</div>

<?php 
include_once './footer.php';
?>