<?php
include_once 'header.php';
include_once 'database.php';
include_once 'session.php';

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

$st = 0;

if(isset($_SESSION['user_id'])){
$query = "SELECT DISTINCT p.id, p.title, p.post, p.image, p.date, p.community_id, c.name, c.icon, u.username
 FROM posts p INNER JOIN communities c ON p.community_id=c.id INNER JOIN subscriptions s ON s.community_id=c.id INNER JOIN users u ON p.user_id=u.id
 WHERE s.user_id=?
 ORDER BY p.date DESC";
$stmt = $pdo->prepare($query);
$stmt->execute([$_SESSION['user_id']]);
}
?>

<main role="main">

    <div class="container text-center mt-5">
      <h3><i class="fas fa-home-lg-alt"></i></h3>
      <h1>Home</h1>
      <p class="lead text-muted">Read-it is a reddit clone I'm making for a school project. <br>It's goal is to have the basic functions of reddit.</p>
      <p>
        <a href="communities.php" class="btn btn-primary my-2">Explore Communities</a>
      </p>
    </div>

  <div class="album py-5 bg-light">
    <div class="container">

      <div class="row mt-5">
        <?php 
        if(isset($_SESSION['user_id'])){
          $st = 0;

          if($stmt->rowCount() > 0) {
            while($st < $stmt->rowCount()) {
                $post = $stmt->fetch();
                $date = time_elapsed_string($post['date']);
                echo '<div class="col-2"></div>
                <div class="col-lg-8">
                  <div class="card mb-4 shadow-sm">
                    <div class="card-title my-2">
                      <div class="row">
                        <div class="col-md-3 text-md-left px-4">
                        <a href="community_show.php?id=' . $post['community_id'] . '"><img src="community-uploads/' . $post['community_id'] . '/' . $post['icon'] .'" class="img-fluid" width="32" height="32" style="border-radius: 50%;">
                          <span class="text-muted">r/</span>' . $post['name'] . '</a>
                        </div>
                        <div class="col-md-6 text-md-center">
                          <h4 class="px-4">' . $post['title'] . '</h4>
                        </div>
                        <div class="col-md-3 text-md-right px-4">
                        By <span class="text-muted"> u/</span>' . $post['username'] . '
                        </div>
                      </div>
                    </div>';
                    if($post['image']!=""){
                    echo '<img src="post-uploads/' . $post['id'] . '/' . $post['image'] .'" class="img-fluid" width="100%" height="100%">';
                    }
                   echo '<div class="card-body">
                      <p class="card-text" style="overflow: hidden; height: 6rem;">' . $post['post'] . '</p>
                      <div class="d-flex justify-content-between align-items-center">
                        <div class="btn-group">
                          <i class="far fa-arrow-square-up fa-2x mx-1"></i><span class="font-weight-bold">0</span> 
                          <i class="far fa-arrow-square-down mx-1 fa-2x"></i><span class="font-weight-bold">0</span>
                        </div>
                        <small class="text-muted">' . $date . '</small>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-2"></div>';
                $st++;
            }
          } 
          else {
            $st = 0;

            $query = "SELECT DISTINCT p.id, p.title, p.post, p.image, p.date, p.community_id, c.name, c.icon, u.username
            FROM posts p INNER JOIN communities c ON p.community_id=c.id INNER JOIN subscriptions s ON s.community_id=c.id INNER JOIN users u ON p.user_id=u.id
            ORDER BY RAND()";
            $stmt = $pdo->prepare($query);
            $stmt->execute([]);
            if($stmt->rowCount() > 0) {
              while($st < $stmt->rowCount()) {
                $post = $stmt->fetch();
                $date = time_elapsed_string($post['date']);
                echo '<div class="col-2"></div>
            <div class="col-lg-8">
              <div class="card mb-4 shadow-sm">
                <div class="card-title my-2">
                  <div class="row">
                    <div class="col-md-3 text-md-left px-4">
                    <a href="community_show.php?id=' . $post['community_id'] . '"><img src="community-uploads/' . $post['community_id'] . '/' . $post['icon'] .'" class="img-fluid" width="32" height="32" style="border-radius: 50%;">
                      <span class="text-muted">r/</span>' . $post['name'] . '</a>
                    </div>
                    <div class="col-md-6 text-md-center">
                      <h4 class="px-4">' . $post['title'] . '</h4>
                    </div>
                    <div class="col-md-3 text-md-right px-4">
                    By <span class="text-muted"> u/</span>' . $post['username'] . '
                    </div>
                  </div>
                </div>';
                if($post['image']!=""){
                echo '<img src="post-uploads/' . $post['id'] . '/' . $post['image'] .'" class="img-fluid" width="100%" height="100%">';
                }
               echo '<div class="card-body">
                  <p class="card-text" style="overflow: hidden; height: 6rem;">' . $post['post'] . '</p>
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group">
                      <i class="far fa-arrow-square-up fa-2x mx-1"></i><span class="font-weight-bold">0</span> 
                      <i class="far fa-arrow-square-down mx-1 fa-2x"></i><span class="font-weight-bold">0</span>
                    </div>
                    <small class="text-muted">' . $date . '</small>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-2"></div>';
                $st++;
              }
            }
          }
        }
        else {
          $query = "SELECT DISTINCT p.id, p.title, p.post, p.image, p.date, p.community_id, c.name, c.icon, u.username
          FROM posts p INNER JOIN communities c ON p.community_id=c.id INNER JOIN subscriptions s ON s.community_id=c.id INNER JOIN users u ON p.user_id=u.id
          ORDER BY RAND()";
          $stmt = $pdo->prepare($query);
          $stmt->execute([]);
          if($stmt->rowCount() > 0) {
            while($st < $stmt->rowCount()) {
              $post = $stmt->fetch();
              $date = time_elapsed_string($post['date']);
              echo '<div class="col-2"></div>
            <div class="col-lg-8">
              <div class="card mb-4 shadow-sm">
                <div class="card-title my-2">
                  <div class="row">
                    <div class="col-md-3 text-md-left px-4">
                    <a href="community_show.php?id=' . $post['community_id'] . '"><img src="community-uploads/' . $post['community_id'] . '/' . $post['icon'] .'" class="img-fluid" width="32" height="32" style="border-radius: 50%;">
                      <span class="text-muted">r/</span>' . $post['name'] . '</a>
                    </div>
                    <div class="col-md-6 text-md-center">
                      <h4 class="px-4">' . $post['title'] . '</h4>
                    </div>
                    <div class="col-md-3 text-md-right px-4">
                    By <span class="text-muted"> u/</span>' . $post['username'] . '
                    </div>
                  </div>
                </div>';
                if($post['image']!=""){
                echo '<img src="post-uploads/' . $post['id'] . '/' . $post['image'] .'" class="img-fluid" width="100%" height="100%">';
                }
               echo '<div class="card-body">
                  <p class="card-text" style="overflow: hidden; height: 6rem;">' . $post['post'] . '</p>
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group">
                      <i class="far fa-arrow-square-up fa-2x mx-1"></i><span class="font-weight-bold">0</span> 
                      <i class="far fa-arrow-square-down mx-1 fa-2x"></i><span class="font-weight-bold">0</span>
                    </div>
                    <small class="text-muted">' . $date . '</small>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-2"></div>';
              $st++;
            }
          }
        }
        ?>
</main>

<?php
include_once 'footer.php';
?>