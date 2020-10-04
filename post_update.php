<?php
    include_once 'session.php';
    include_once 'database.php';

    $id = $_POST['id'];
    $title = $_POST['title'];
    $post = $_POST['post'];
    $image = $_FILES["image"]["name"];
    $st = 0;
    $_SESSION['post_id'] = $id;

        if($image!=""){
            include_once 'post_file_upload.php';

            if($uploadOk!=0){
            $query = "UPDATE posts SET title=?, post=?, image=? WHERE id=?";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$title, $post, $image, $id]);

            header('refresh:5;url=post_edit.php?id=' . $id);
            }
            else{
                if($isup == 1){
                    $query = "UPDATE posts SET title=?, post=?, image=? WHERE id=?";
                    $stmt = $pdo->prepare($query);
                    $stmt->execute([$title, $post, $image, $id]);

                    header('refresh:5;url=post_edit.php?id=' . $id);
                }
                else{
                $query = "UPDATE posts SET title=?, post=? WHERE id=?";
                $stmt = $pdo->prepare($query);
                $stmt->execute([$title, $post, $id]);
        
                header('refresh:5;url=post_edit.php?id=' . $id);
                }
            }
        }
        else{
            echo 'No file was uploaded.';
            $query = "UPDATE posts SET title=?, post=? WHERE id=?";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$title, $post, $id]);
            header('refresh:5;url=post_edit.php?id=' . $id);
        }

?>