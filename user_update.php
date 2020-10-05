<?php 
    include_once 'header.php';
    include_once 'database.php';
    include_once 'session.php';
    if(!isset($_SESSION['user_id'])){
        header('location: index.php');
    }

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password_current = $_POST['password_current'];
    $password_new = $_POST['password_new'];
    $password_new_confirm = $_POST['password_new_confirm'];
    $displayname=$_POST['displayName'];
    $descripton=$_POST['description'];
    $avatar=$_FILES["image"]["name"];
    if(empty($username) || empty($email) || empty($password_current))
    {
        header('location: index.php');
    }
    
    if($avatar!=""){
        if($password_new == $password_new_confirm)
        {
            if(strlen($password_new) >= 5){
        
                $query = "SELECT * FROM users WHERE email=?";
                $stmt = $pdo->prepare($query);
                $stmt->execute([$email]);
        
                if ($stmt->rowCount() == 1) {
                    $user = $stmt->fetch();
                }
        
                else{
                    echo '
                <script type="text/javascript">

                Swal.fire({
                    icon: "error",
                    text: "That email address is taken!",
                }).then(function() {
                    window.location = "profile.php";
                });

                </script>
                ';
                }
                $query = "SELECT * FROM users WHERE username=?";
                $stmt = $pdo->prepare($query);
                $stmt->execute([$username]);
        
                if ($stmt->rowCount() == 1) {
                    $user = $stmt->fetch();
                }
        
                else{
                    echo '
                <script type="text/javascript">

                Swal.fire({
                    icon: "error",
                    text: "That username address is taken!",
                }).then(function() {
                    window.location = "profile.php";
                });

                </script>
                ';
                }
        
                if (password_verify($password_current, $user['pass'])) {
                    include_once './user_file_upload.php';

                    if($uploadOk!=0){
                        if($password_new != ''){
                        $pass = password_hash($password_new, PASSWORD_DEFAULT);
                        }
                        else{
                            $pass = password_hash($password_current, PASSWORD_DEFAULT);
                        }
            
                        $query2 = "UPDATE users SET username=?, email=?, pass=?, displayname=?, description=?, avatar=?, dateUpdated=CURRENT_TIMESTAMP WHERE email=?;";
                        $stmt = $pdo->prepare($query2);
                        $stmt->execute([$username,$email,$pass,$displayname,$descripton,$avatar,$email]);
            
                        $query3 = "SELECT * FROM users WHERE email=?";
                        $stmt = $pdo->prepare($query3);
                        $stmt->execute([$email]);
                        $user2 = $stmt->fetch();
            
                        $_SESSION['user_id'] = $user2['id']; 
                        $_SESSION['username'] = $user2['username']; 
                        $_SESSION['email'] = $user2['email'];
                        $_SESSION['displayname'] = $user2['displayname'];
                        $_SESSION['description'] = $user2['description'];
                        $_SESSION['avatar'] = $user2['avatar'];
                        echo '
                        <script type="text/javascript">
            
                        Swal.fire({
                            icon: "success",
                            text: "Profile successfully updated!",
                        }).then(function() {
                            window.location = "profile.php";
                        });
            
                        </script>
                        ';
                    }
                    else{
                        if($password_new != ''){
                            $pass = password_hash($password_new, PASSWORD_DEFAULT);
                        }
                        else{
                            $pass = password_hash($password_current, PASSWORD_DEFAULT);
                        }
                        if($isup == 1){
                            $query2 = "UPDATE users SET username=?, email=?, pass=?, displayname=?, description=?, avatar=?, dateUpdated=CURRENT_TIMESTAMP WHERE email=?;";
                            $stmt = $pdo->prepare($query2);
                            $stmt->execute([$username,$email,$pass,$displayname,$descripton,$avatar,$email]);
                            $query3 = "SELECT * FROM users WHERE email=?";
                            $stmt = $pdo->prepare($query3);
                            $stmt->execute([$email]);
                            $user2 = $stmt->fetch();

                            $_SESSION['user_id'] = $user2['id']; 
                            $_SESSION['username'] = $user2['username']; 
                            $_SESSION['email'] = $user2['email'];
                            $_SESSION['displayname'] = $user2['displayname'];
                            $_SESSION['description'] = $user2['description'];
                            $_SESSION['avatar'] = $user2['avatar'];
                        
                            echo '
                        <script type="text/javascript">
            
                        Swal.fire({
                            icon: "success",
                            text: "Profile successfully updated!",
                        }).then(function() {
                            window.location = "profile.php";
                        });
            
                        </script>
                        ';
                        }
                        else{
                            $query2 = "UPDATE users SET username=?, email=?, pass=?, displayname=?, description=?, dateUpdated=CURRENT_TIMESTAMP WHERE email=?;";
                            $stmt = $pdo->prepare($query2);
                            $stmt->execute([$username,$email,$pass,$displayname,$descripton,$email]);
                            $query3 = "SELECT * FROM users WHERE email=?";
                            $stmt = $pdo->prepare($query3);
                            $stmt->execute([$email]);
                            $user2 = $stmt->fetch();

                            $_SESSION['user_id'] = $user2['id']; 
                            $_SESSION['username'] = $user2['username']; 
                            $_SESSION['email'] = $user2['email'];
                            $_SESSION['displayname'] = $user2['displayname'];
                            $_SESSION['description'] = $user2['description'];
                            $_SESSION['avatar'] = $user2['avatar'];
                            
                            echo '
                            <script type="text/javascript">
                
                            Swal.fire({
                                icon: "success",
                                text: "Profile successfully updated!",
                            }).then(function() {
                                window.location = "profile.php";
                            });
                
                            </script>
                            ';
                        }
                    }
                }
                else{
                    echo '
                <script type="text/javascript">
    
                Swal.fire({
                    icon: "error",
                    text: "Current password is not correct!",
                }).then(function() {
                    window.location = "profile.php";
                });
    
                </script>
                ';
                }
            }
            else{
                echo '
                <script type="text/javascript">
    
                Swal.fire({
                    icon: "error",
                    text: "New passwords too short!",
                }).then(function() {
                    window.location = "profile.php";
                });
    
                </script>
                '; 
            }
        }
        else{
            echo '
            <script type="text/javascript">

            Swal.fire({
                icon: "error",
                text: "New passwords do not match!",
            }).then(function() {
                window.location = "profile.php";
            });

            </script>
            ';
        }
    }
    else
    {
        if($password_new == $password_new_confirm)
        {
    
            $query = "SELECT * FROM users WHERE email=?";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$email]);
    
            if ($stmt->rowCount() == 1) {
                $user = $stmt->fetch();
            }
    
            else{
                echo '
            <script type="text/javascript">

            Swal.fire({
                icon: "error",
                text: "That email address is taken!",
            }).then(function() {
                window.location = "profile.php";
            });

            </script>
            ';
            }
            $query = "SELECT * FROM users WHERE username=?";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$username]);
    
            if ($stmt->rowCount() == 1) {
                $user = $stmt->fetch();
            }
    
            else{
                echo '
            <script type="text/javascript">

            Swal.fire({
                icon: "error",
                text: "That username address is taken!",
            }).then(function() {
                window.location = "profile.php";
            });

            </script>
            ';
            }
    
            if (password_verify($password_current, $user['pass'])) {
                
                if($password_new != ''){
                $pass = password_hash($password_new, PASSWORD_DEFAULT);
                }
                else{
                    $pass = password_hash($password_current, PASSWORD_DEFAULT);
                }
    
                $query2 = "UPDATE users SET username=?, email=?, pass=?, displayname=?, description=?, dateUpdated=CURRENT_TIMESTAMP WHERE email=?;";
                $stmt = $pdo->prepare($query2);
                $stmt->execute([$username,$email,$pass,$displayname,$descripton,$email]);
    
                $query3 = "SELECT * FROM users WHERE email=?";
                $stmt = $pdo->prepare($query3);
                $stmt->execute([$email]);
                $user2 = $stmt->fetch();
    
                $_SESSION['user_id'] = $user2['id']; 
                $_SESSION['username'] = $user2['username']; 
                $_SESSION['email'] = $user2['email'];
                $_SESSION['displayname'] = $user2['displayname'];
                $_SESSION['description'] = $user2['description'];
                $_SESSION['avatar'] = $user2['avatar'];
                echo '
                    <script type="text/javascript">
        
                    Swal.fire({
                        icon: "success",
                        text: "Profile successfully updated!",
                    }).then(function() {
                        window.location = "profile.php";
                    });
        
                    </script>
                    ';
            }
            else{
                 echo '
                <script type="text/javascript">
    
                Swal.fire({
                    icon: "error",
                    text: "Current password is not correct!",
                }).then(function() {
                    window.location = "profile.php";
                });
    
                </script>
                ';
            }
        }
        else{
            echo '
            <script type="text/javascript">

            Swal.fire({
                icon: "error",
                text: "New passwords do not match!",
            }).then(function() {
                window.location = "profile.php";
            });

            </script>
            ';
        }
    }

?>