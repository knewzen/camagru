<?php 
    session_start();
    include("parts/header.php");
    
    if (isset($_GET['m1'])) {
      echo (alert("Please loggin or signin to do that.", "is-warning"));
    }
    else if (isset($_GET['m2'])) {
      echo (alert("You successfully comment a picture.", "is-success"));
    }
    else if (isset($_GET['m3'])) {
      echo (alert("Something went wrong.", "is-danger"));
    }
    else if (isset($_GET['m4'])) {
      echo (alert("You successfully like a picture.", "is-success"));
    }
        require_once 'config/database.php';
        $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $req = $pdo->prepare("SELECT * FROM gallery");
        $req->execute();
        $data = $req->fetchAll();
        $req->closeCursor();
        echo "<div id=\"gallerytableau\">";
        foreach ($data as $elem) {
            $like = get_like($elem['id'], $pdo);
            add_card($elem['img'], $elem['id'], $like);
        }
        echo "</div>";
        function add_card($img, $id, $like) {
          echo "<div class=\"card mycard\">
              <div class=\"card-image\" id=\"$id\">
                <figure class=\"image is-4by3\">
                  <img src=\"$img\">
                </figure>
                 </div>
              <div class=\"card-content\">
                <div class=\"media\">
                  <div class=\"media-content\">
                    <p class=\"title is-4\">John Smith</p>
                  </div>
                </div>
                <div class=\"content\">
                  Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                  Phasellus nec iaculis mauris.
                  <br>
                  <time datetime=\"2016-1-1\">11:09 PM - 1 Jan 2016</time>
                  <form class=\"field has-addons\" method=\"post\" action=\"functions/postcomments.php\">
                  <div class=\"control\">
                    <input name=\"imgid\" value=\"$id\" hidden>
                    <input name=\"text\" class=\"input\" type=\"text\" placeholder=\"Comment\">
                  </div>
                  <div class=\"control\">
                    <input type=\"submit\" value=\"Send\" class=\"button is-info\">
                  </div>
                </form>
                </div>
              </div>
              <footer class=\"card-footer\">
              </span>
              <span class=\"card-footer-item\">
              $like
              </span>
              <a class=\"card-footer-item\" method=\"post\" href=\"functions/like.php?img=$id\">
                Like
              </a>
              </div>";
        }
        function get_like($id, $pdo) {
          $like = 'like';
          $req = $pdo->prepare('SELECT * FROM `like` WHERE galleryid=:galleryid');
          $req->execute(array(':galleryid' => $id));
          $c = count($req->fetchAll());
          $req->closeCursor();
          return ($c);
        }
?>
<div class="modal">
          <div class="modal-background"></div>
          <div class="modal-card">
            <header class="modal-card-head">
              <p class="modal-card-title">Comments</p>
              <button class="delete my-close" aria-label="close"></button>
            </header>
            <section class="modal-card-body" id="modalcontent">
            </section>
          </div>
          </div>
<?php
  include("parts/footer.html");        
  function alert($string, $type) {
    $s = "<section class=\"hero ".$type."\"><div class=\"hero-body container\">".$string."</div></section>";
    return $s;
}
?>

<script src="js/gallery.js"></script>