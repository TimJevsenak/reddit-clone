<?php
include_once './header.php';
?>

<div class="container my-5 text-center">
    <div class="row">
        <div class="col">
            <h1>Title of front page<i class="fad fa-bookmark"></i></h1>
            <p>Lorem ipsum....................................</p>
            <?php if(isset($_SESSION['user_id']))echo $_SESSION['user_id']; ?>
        </div>
    </div>
</div> 

<?php
include_once './footer.php';
?>