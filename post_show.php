<?php 
    include_once 'header.php';
    include_once 'session.php';
    include_once 'database.php';

    $id = $_GET['id'];
    $st = 0;

    function time_elapsed_string($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);
      
        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;
      
        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }
      
        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
      }
    
    $query = "SELECT * FROM posts WHERE id=?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$id]);
    $post = $stmt->fetch();

    $date = time_elapsed_string($post['date']);
?>

    <div class="row mt-5">
        <div class="col-2"></div>
        <div class="col-lg-8 text-center">
            <h2><?php echo $post['title']; ?></h2>
            <?php
                if(isset($post['image'])){ 
                echo '<img src="post-uploads/' . $id . '/' . $post['image'] . '" class="img-fluid" width="80%" height="80%">';
                }
            ?>
            <p class="text-justify mt-4"><?php echo $post['post'] ?></p>
            <p class="text-right text-muted mt-4">Posted <?php echo $date ?></p>
        </div>
        <div class="col-2"></div>
        <div class="container text-center">
            <h3 class="my-3">Comments</h3>
            <?php 
                if(isset($_SESSION['user_id'])){
                echo '<button type="button" class="btn btn-secondary mb-5" data-toggle="modal" data-target="#CommentModal">
                Leave a comment
                </button>';
                }
                else{
                    echo '<a href="register.php"><button type="button" class="btn btn-light mb-5">
                    Sign up to comment
                    </button></a>';
                }
            ?>
                <!-- Modal -->
                <div class="modal fade" id="CommentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalCenterTitle">Leave a comment</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="comment_insert.php?id=<?php echo $id ?>" method="POST">
                        <div class="modal-body">
                            <textarea name="text" class="form-control" rows="3" placeholder="Comment" required=""></textarea>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary" type="submit">Post your comment</button>
                        </div>
                        </form>
                        </div>
                    </div>
                </div>
            <div class="row">
                <div class="col-2"></div>
                <div class="col-lg-8">
                    <?php 
                        $query = "SELECT * FROM comments WHERE post_id=?";
                        $stmt = $pdo->prepare($query);
                        $stmt->execute([$id]);
                        if($stmt->rowCount() > 0) {
                            while($st < $stmt->rowCount()) {
                                $comment = $stmt->fetch();
                                $date = time_elapsed_string($comment['date']);

                                echo '<div class="my-4"><p class="m-0">' . $comment['text'] . '</p><small class="text-muted">Commented ' . $date . '</small>';
                                $st++;
                            }
                        }
                        else{
                            echo '<p class="text-muted mb-5" style="font-size: 12px;">No comments yet!<br>Be the first one to comment.</p>';
                        }                      
                        
                    ?>
                </div>
                <div class="col-2"></div>
            </div>
        </div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>
</html>