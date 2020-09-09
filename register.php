<?php
include_once './header.php';
?>

<div class="container">
    <div class="row">
        <div class="col-4"></div>
        <div class="col-4 my-5">
            <form class="form-signin">
                <h1 class="h2 my-4 font-weight-normal text-center">Sign Up</h1>
                <label for="inputEmail" class="sr-only">Email address</label>
                <input type="email" id="inputEmail" class="form-control my-1" placeholder="Email address" required="" autofocus="">
                <label for="inputUsername" class="sr-only">Username</label>
                <input type="text" id="inputUsername" class="form-control my-1" placeholder="Username" required="">
                <label for="inputPassword" class="sr-only">Password</label>
                <input type="password" id="inputPassword" class="form-control my-1" placeholder="Password" required="">
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