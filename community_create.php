<?php
include_once 'header.php';
include_once 'session.php';
include_once 'database.php';
?>

<div class="container">
    <div class="row">
        <div class="col-4 mt-5">
        <a href="profile.php"><button type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button></a>
        </div>
        <div class="col-4 my-5 text-right">
            <form class="form-signin" action="community_insert.php" method="post" enctype="multipart/form-data">
                <h1 class="h2 mb-4 font-weight-normal text-center">Create a community</h1>
                <input name="name" type="text" class="form-control my-1" placeholder="Name" required="" autofocus="">
                <input name="title" type="text" class="form-control my-1" placeholder="Title (eg. The Best Community In The World)" required="">
                <textarea name="description" class="form-control" id="Textarea" rows="3" placeholder="Description" required=""></textarea>
                <div class="input-group my-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-default">Community icon</span>
                    </div>
                    <input name="image" type="file" id="image" class="form-control-file my-1" required="">
                </div>
                <div class="text-center">
                    <button class="btn btn-success" type="submit" name="submit">Create</button>
                </div>
            </form>
        </div>
        <div class="col-4"></div>
    </div>
</div>

<?php 
include_once './footer.php';
?>