<?php
    include_once 'session.php';
    include_once 'database.php';

    $id = $_POST['id'];
    $name = $_POST['name'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $icon = $_FILES["image"]["name"];
    $taken = 0;
    $st = 0;
    $_SESSION['community_id'] = $id;

    $query = "SELECT * FROM communities";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    if($stmt->rowCount() > 0) {
        while($st < $stmt->rowCount()) {
            $community = $stmt->fetch();
            if($name == $community['name']){
                $taken = 1;
            }
            $st++;
        }
    }

    if($taken)
    {
        echo 'Name taken.';
        if($icon!=""){
            include_once 'community_file_upload.php';

            if($uploadOk!=0){
            $query2 = "UPDATE communities SET description=?, title=?, icon=? WHERE id=?";
            $stmt = $pdo->prepare($query2);
            $stmt->execute([$description, $title, $icon, $id]);

            header('refresh:5;url=community_edit.php?id=' . $id);
            }
            else{
                if($isup == 1){
                    $query2 = "UPDATE communities SET description=?, title=?, icon=? WHERE id=?";
                    $stmt = $pdo->prepare($query2);
                    $stmt->execute([$description, $title, $icon, $id]);
        
                    header('refresh:5;url=community_edit.php?id=' . $id); 
                }
                else{
                $query2 = "UPDATE communities SET description=?, title=? WHERE id=?";
                $stmt = $pdo->prepare($query2);
                $stmt->execute([$description, $title, $id]);
        
                header('refresh:5;url=community_edit.php?id=' . $id);
                }
            }
        }
        else{
            echo 'No file was uploaded.';
            $query2 = "UPDATE communities SET description=?, title=? WHERE id=?";
            $stmt = $pdo->prepare($query2);
            $stmt->execute([$description, $title, $id]);
            header('refresh:5;url=community_edit.php?id=' . $id);
        }
    }

    else{
        if($icon!=""){
            include_once 'community_file_upload.php';

            if($uploadOk!=0){
            $query2 = "UPDATE communities SET name=?, description=?, title=?, icon=? WHERE id=?";
            $stmt = $pdo->prepare($query2);
            $stmt->execute([$name, $description, $title, $icon,  $id]);

            header('refresh:5;url=community_edit.php?id=' . $id);
            }
            else{
                if($isup == 1){
                    $query2 = "UPDATE communities SET description=?, title=?, icon=? WHERE id=?";
                    $stmt = $pdo->prepare($query2);
                    $stmt->execute([$description, $title, $icon, $id]);
        
                    header('refresh:5;url=community_edit.php?id=' . $id); 
                }
                else{
                $query2 = "UPDATE communities SET name=?, description=?, title=? WHERE id=?";
                $stmt = $pdo->prepare($query2);
                $stmt->execute([$name, $description, $title, $id]);
        
                header('refresh:5;url=community_edit.php?id=' . $id);
                }
            }
        }
        else{
            echo 'No file was uploaded.';
            $query2 = "UPDATE communities SET name=?, description=?, title=? WHERE id=?";
            $stmt = $pdo->prepare($query2);
            $stmt->execute([$name, $description, $title, $id]);
        
            header('refresh:5;url=community_edit.php?id=' . $id);
        }
        
    }

?>