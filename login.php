<?php
include_once 'header.php';
include_once 'session.php';
include_once 'database.php';
?>
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/sl_SI/sdk.js#xfbml=1&version=v8.0&appId=950579208754531&autoLogAppEvents=1" nonce="5T364vLs"></script>
<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '{950579208754531}',
      cookie     : true,
      xfbml      : true,
      version    : '{v8.0}'
    });
      
    FB.AppEvents.logPageView();   
      
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "https://connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));



function checkLoginState() {
  FB.getLoginStatus(function(response) {
    if (response.status === 'connected') {
   // console.log(response.authResponse.accessToken);
    FB.api('/me', { locale: 'si_SI', fields: 'name, email,birthday, hometown,education,gender,website,work' },
          function(response) {
            var form = $('<form action="socialLogin.php" method="post">' +
            '<input type="text" name="email" value="' + response.email + '" />'
            +
            '<input type="text" name="username" value="' + response.name + '" />'+
            '</form>');
            $('body').append(form);
            form.submit();

            console.log(response.email);
            console.log(response.name);
          }
        );
  }
  });
}
</script>

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
                    <div class="fb-login-button btn" data-size="large" data-button-type="continue_with" data-layout="default" data-auto-logout-link="false" data-use-continue-as="false" data-width=""></div>
                </div>
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
    var form = $('<form action="login_check_google.php" method="post">' +
            '<input type="text" name="email" value="' + profile.getEmail() + '" />'
            +
            '<input type="text" name="username" value="' + profile.getName() + '" />'+
            '</form>');
            $('body').append(form);
            form.submit();
    gapi.auth2.getAuthInstance().disconnect();
}
</script>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>
</html>