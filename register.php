<?php
include_once 'header.php';
?>

<div class="container">
    <div class="row">
        <div class="col-4"></div>
        <div class="col-lg-4 my-5 text-center">
            <form class="form-signin" action="user_insert.php" method="post">
                <h1 class="h2 my-4 font-weight-normal text-center">Sign Up</h1>
                <label for="inputEmail" class="sr-only">Email address</label>
                <input name="email" type="email" id="inputEmail" class="form-control my-1" placeholder="Email address" required="" autofocus="">
                <label for="inputUsername" class="sr-only">Username</label>
                <input name="username" type="text" id="inputUsername" class="form-control my-1" placeholder="Username" required="">
                <label for="inputPassword" class="sr-only">Password</label>
                <input name="password" type="password" id="inputPassword" class="form-control my-1" placeholder="Password" required="">
                <label for="inputPasswordConfirm" class="sr-only">Confirm password</label>
                <input name="password_confirm" type="password" id="inputPasswordConfirm" class="form-control my-1" placeholder="Confirm password" required="">
                <div class="text-center mt-5">
                    <button class="btn btn-success" type="submit">Sign Up</button>
                </div>
            </form>
            <div class="mt-5">
            <a class="mt-5" href="login.php">Already have an account?</a><br>
            </div>
        </div>
        <div class="col-4"></div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>
</html>