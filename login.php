<?php
include_once 'header.php';
include_once 'session.php';
include_once 'database.php';


?>
<div class="container">
    <div class="row">
        <div class="col-4"></div>
        <div class="col-lg-4 text-center my-5">
            <form action="login_check.php" method="post" class="form-signin">
                <h1 class="h2 my-4 font-weight-normal text-center">Sign In</h1>
                <label for="inputEmail" class="sr-only">Email address</label>
                <input name="email" type="email" id="inputEmail" class="form-control my-1" placeholder="Email address" required="" autofocus="">
                <label for="inputPassword" class="sr-only">Password</label>
                <input name="password" type="password" id="inputPassword" class="form-control my-1" placeholder="Password" required="">
                <div class="text-center mt-5">
                    <button class="btn btn-primary" type="submit">Sign in</button>
                    <h5 class="my-4">OR</h5>
                    <div class="g-signin2 btn" data-onsuccess="onSignIn"></div>
                </div>
            </form>
            <form method="post" id="theForm" action="login_check_google.php">
                <input id="username" type="hidden" name="username" value="John">
                <input id="email" type="hidden" name="email" value="2pm">
            </form>
            <div class="mt-5">
            <a class="mt-5" href="register.php">Don't have an account?</a><br>
            <a class="my-2" href="forgot_password.php">Forgot password?</a>
            </div>
        </div>
        <div class="col-4"></div>
    </div>
</div>

<script>
    function onSignIn(googleUser) {
    var profile = googleUser.getBasicProfile();
    console.log('Name: ' + profile.getName());
    console.log('Email: ' + profile.getEmail());
    $(function () {
        $('#username').val(profile.getName());
    });
    $(function () {
        $('#email').val(profile.getEmail());
    });
    document.getElementById('theForm').submit();
    gapi.auth2.getAuthInstance().disconnect();
}
</script>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>
</html>