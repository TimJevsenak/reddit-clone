<?php 
    include_once 'header.php';
    include_once 'database.php';
    include_once 'session.php';
    $passkey = $_GET['passkey'];

    $query = "SELECT * FROM users WHERE passkey=?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$passkey]);

    if($stmt->rowCount()==1){
        echo '<div class="row">
        <div class="col-4"></div>
        <div class="col-lg-4">
            <form action="reset_password.php?id=' . $passkey . '" method="post" class="form-signin">
            <h1 class="h2 my-4 font-weight-normal text-center">Forgot password</h1>
            <input name="passnew" type="password_new" id="inputEmail" class="form-control my-1" placeholder="New password" required="" autofocus="">
            <input name="confpass" type="password_confirm" id="inputEmail" class="form-control my-1" placeholder="Confirm password" required="">
            <div class="text-center mt-5">
                <button class="btn btn-primary" type="submit">Reset password</button>
            </div>
            </form>
        </div>
        <div class="col-4"></div>
    </div>';
    }
    else{
        echo '
                <script type="text/javascript">

                Swal.fire({
                    icon: "error",
                    text: "Something went wrong!",
                }).then(function() {
                    window.location = "login.php";
                });

                </script>
                ';
    }
?>
