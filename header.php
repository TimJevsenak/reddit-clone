<?php
include_once './session.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="google-signin-client_id" content="83765887749-j0ets08rou0pa7fkc1fi3i81u95o0rmn.apps.googleusercontent.com">
    <title>read-it</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="siteIcons/logo.jpg" type="png" sizes="16x16">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://kit.fontawesome.com/9546f008dc.js" crossorigin="anonymous"></script>
    <script src="icons.js" defer></script>
    <script src="https://apis.google.com/js/platform.js" async defer></script>
</head>
<body>
    <nav class="navbar navbar-expand-md navbar-dark sticky-top" style="background-color: #232323;">
  <a class="navbar-brand text-lowercase" href="index.php"><img src="siteIcons/logo.jpg" height="32px" width="32px"> Read-It</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarCollapse">
    <!--<form class="form-inline mt-2 mt-md-0">
      <input id="search" class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>-->
    <?php
      if(!isset($_SESSION['user_id']))
      {
        echo '
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" href="login.php"><button class="btn btn-sm btn-secondary my-2 my-sm-0 text-light">Sign In</button></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="register.php"><button class="btn btn-sm btn-light my-2 my-sm-0">Sign Up</button></a>
          </li>
        </ul>
        ';
      }
      else{
        echo '
        <ul class="navbar-nav ml-auto">';
        if($_SESSION['admin']){
        echo '<li class="nav-item">
            <a class="nav-link pb-sm-0" href="admin.php"><button class="btn btn-sm btn-dark my-2 my-sm-0">Admin panel</button></a>
          </li>';}
        echo '<li class="nav-item">
            <a class="nav-link pb-sm-0" href="logout.php"><button class="btn btn-sm btn-info my-2 my-sm-0">Log Out</button></a>
          </li>';
        echo '<li class="nav-item">
              <a class="nav-link" href="profile.php"><button class="btn btn-sm btn-outline-light my-2 my-sm-0">';
        echo $_SESSION['username'];
        echo '</button></a></li>';
        if($_SESSION['avatar']!="")
        {
        echo '
        <ul class="navbar-nav">
        <li class="nav-item">
          <img src="user-uploads/' . $_SESSION['user_id'] . "/" . $_SESSION['avatar'] . '" class="img-fluid" alt="Avatar" width="44" height="44" style="border-radius: 50%;">
        </li>';
        }
      }
    ?>
  </div>
</nav>
