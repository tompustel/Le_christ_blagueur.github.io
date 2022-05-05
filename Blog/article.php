<?php 
require_once 'php/config.php';
require_once 'php/functions.php';

if(!empty($_GET['id'])) {
	$id = htmlspecialchars($_GET['id']);

	$article = $bdd->prepare('SELECT *, DATE_FORMAT(datetime_post, "%d %M %Y") date_formatee FROM articles WHERE id = ?');
	$article->execute([$id]);

	$article = $article->fetch(PDO::FETCH_ASSOC);

  if(!$article) {
    header('Location: /');
    exit();
  }
} else {
    header('Location: /');
    exit();
}
?>

<!DOCTYPE html>
<html>
    <head>
  <title><?= $article['titre'] ?></title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <script src="https://kit.fontawesome.com/8e87ace701.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css"/>
    </head>
    
    <body>
<section class="page">
<?php include_once 'includes/navi.php' ?>

<div class="article_unique">
  
  <img src ="images/miniatures/<?= $article['id'] ?>.jpg" alt="">
  <br>
  <h3><?= $article['titre'] ?></h3>
  <br>
  <div class="contenu">
  <p><?= htmlspecialchars_decode(nl2br($article['contenu'])) ?></p>
  </div>
  <br>
  <div class="date">
  <p><?= $article['date_formatee'] ?></p>
  </div>

</div>

<?php include_once 'includes/foot.php' ?>
</section>
    </body>
</html>