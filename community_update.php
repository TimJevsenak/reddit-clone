<?php
    include_once 'header.php';
    include_once 'session.php';
    include_once 'database.php';

    $id = $_POST['id'];
    $name = $_POST['name'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $icon = $_FILES["image"]["name"];
    $st = 0;
    $_SESSION['community_id'] = $id;

    $query = "SELECT * FROM communities WHERE name=?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$name]);

    if($stmt->rowCount() > 0)
    {
        if($icon!=""){
            include_once 'community_file_upload.php';

            if($uploadOk!=0){
            $query2 = "UPDATE communities SET description=?, title=?, icon=? WHERE id=?";
            $stmt = $pdo->prepare($query2);
            $stmt->execute([$description, $title, $icon, $id]);

            echo '
            <script type="text/javascript">

            Swal.fire({
                icon: "success",
                text: "Successfully updated the community!",
            }).then(function() {
                window.location = "community_edit.php?id=' . $id . '";
            });

            </script>
            ';
            }
            else{
                if($isup == 1){
                    $query2 = "UPDATE communities SET description=?, title=?, icon=? WHERE id=?";
                    $stmt = $pdo->prepare($query2);
                    $stmt->execute([$description, $title, $icon, $id]);
        
                    echo '
            <script type="text/javascript">

            Swal.fire({
                icon: "success",
                text: "Successfully updated the community!",
            }).then(function() {
                window.location = "community_edit.php?id=' . $id . '";
            });

            </script>
            '; 
                }
                else{
                $query2 = "UPDATE communities SET description=?, title=? WHERE id=?";
                $stmt = $pdo->prepare($query2);
                $stmt->execute([$description, $title, $id]);
        
                echo '
            <script type="text/javascript">

            Swal.fire({
                icon: "success",
                text: "Successfully updated the community!",
            }).then(function() {
                window.location = "community_edit.php?id=' . $id . '";
            });

            </script>
            ';
                }
            }
        }
        else{
            $query2 = "UPDATE communities SET description=?, title=? WHERE id=?";
            $stmt = $pdo->prepare($query2);
            $stmt->execute([$description, $title, $id]);
            echo '
            <script type="text/javascript">

            Swal.fire({
                icon: "success",
                text: "Successfully updated the community!",
            }).then(function() {
                window.location = "community_edit.php?id=' . $id . '";
            });

            </script>
            ';
        }
        echo '
            <script type="text/javascript">

            Swal.fire({
                icon: "error",
                text: "Name taken!",
            }).then(function() {
                window.location = "community_edit.php?id=' . $id . '";
            });

            </script>
            ';
    }

    else{
        if($icon!=""){
            include_once 'community_file_upload.php';

            if($uploadOk!=0){
            $query2 = "UPDATE communities SET name=?, description=?, title=?, icon=? WHERE id=?";
            $stmt = $pdo->prepare($query2);
            $stmt->execute([$name, $description, $title, $icon,  $id]);

            echo '
            <script type="text/javascript">

            Swal.fire({
                icon: "success",
                text: "Successfully updated the community!",
            }).then(function() {
                window.location = "community_edit.php?id=' . $id . '";
            });

            </script>
            ';
            }
            else{
                if($isup == 1){
                    $query2 = "UPDATE communities SET description=?, title=?, icon=? WHERE id=?";
                    $stmt = $pdo->prepare($query2);
                    $stmt->execute([$description, $title, $icon, $id]);
        
                    echo '
            <script type="text/javascript">

            Swal.fire({
                icon: "success",
                text: "Successfully updated the community!",
            }).then(function() {
                window.location = "community_edit.php?id=' . $id . '";
            });

            </script>
            ';
                }
                else{
                $query2 = "UPDATE communities SET name=?, description=?, title=? WHERE id=?";
                $stmt = $pdo->prepare($query2);
                $stmt->execute([$name, $description, $title, $id]);
        
                echo '
            <script type="text/javascript">

            Swal.fire({
                icon: "success",
                text: "Successfully updated the community!",
            }).then(function() {
                window.location = "community_edit.php?id=' . $id . '";
            });

            </script>
            ';
                }
            }
        }
        else{
            $query2 = "UPDATE communities SET name=?, description=?, title=? WHERE id=?";
            $stmt = $pdo->prepare($query2);
            $stmt->execute([$name, $description, $title, $id]);
        
            echo '
            <script type="text/javascript">

            Swal.fire({
                icon: "success",
                text: "Successfully updated the community!",
            }).then(function() {
                window.location = "community_edit.php?id=' . $id . '";
            });

            </script>
            ';
        }
        
    }

?>