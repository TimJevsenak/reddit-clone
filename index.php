<?php
include_once './header.php';
?>

<div class="container my-5 text-center">
    <div class="row">
        <div class="col">
            <h1 class="my-1">Home <i class="far fa-home"></i></h1>
            <p class="h4 my-1 text-uppercase">Latest posts</p>
            <?php if(isset($_SESSION['user_id']))
            {
                echo "Welcome ";
                echo $_SESSION['displayname'] . '! <br>';
                echo '<img src="uploads/' . $_SESSION['user_id'] . "/" . $_SESSION['avatar'] . '" class="img-fluid img-thumbnail" alt="Avatar">'; 
            }
            ?>
        </div>
    </div>
</div> 

<?php
include_once './footer.php';
?>