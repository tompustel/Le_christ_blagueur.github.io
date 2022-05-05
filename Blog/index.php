<?php 
require_once 'php/config.php';
require_once 'php/functions.php';

$info_utilisateur = '';
$aucun_resultat = false;

if(isset($_GET['categorie']) AND empty($_GET['categorie'])) {
	header('Location: /');
	exit();
}

if(!empty($_GET['categorie'])) {

	$get_categorie = htmlspecialchars($_GET['categorie']);
	$nom_categorie = getNomCategorie($get_categorie);

	$info_utilisateur = "Catégorie ".$nom_categorie;

	if(!$nom_categorie) {
		header('Location: /');
		exit();
	}

	$articles = $bdd->prepare('SELECT *, DATE_FORMAT(datetime_post, "%d %M %Y") date_formatee FROM articles WHERE categorie = ? ORDER BY datetime_post DESC');
	$articles->execute([$get_categorie]);

} elseif(!empty($_GET['q'])) {

	$query = htmlspecialchars($_GET['q']);

	$info_utilisateur = 'Recherche "'.$query.'"';
	
	$articles = $bdd->prepare('SELECT *, DATE_FORMAT(datetime_post, "%d %M %Y") date_formatee FROM articles WHERE titre LIKE ? ORDER BY datetime_post DESC');
	$articles->execute(['%'.$query.'%']);

	if(!$articles->rowCount()) {
		$aucun_resultat = true;
	}

} else {
	$articles = $bdd->query('SELECT *, DATE_FORMAT(datetime_post, "%d %M %Y") date_formatee FROM articles ORDER BY datetime_post DESC');
}


?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title> <?php if($info_utilisateur) { echo $info_utilisateur.' - '; } ?> Le Blog du Christ Blagueur </title>
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <script src="https://kit.fontawesome.com/8e87ace701.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css"/>
</head>
<body>
  <section class="page">
   <!-- Barre de navigation -->
<nav>
    <div class="onglets">
    <a href ="/">Accueil</a>
    <?php while($c = $nav_categories->fetch(PDO::FETCH_ASSOC)) { ?>
        <a href="/?categorie=<?= $c['categorie_url'] ?>"><?= $c['categorie'] ?></a>
        <?php } ?>
    </div>

    <div class="sidebar">
    <form method="GET" action="/">
			<input type="text" name="q" placeholder="Rechercher..."<?php if(isset($query)) { echo ' value="'.$query.'"'; } ?>>
			<input type="submit" value="OK">
		</form>
      </div> 
</nav>
   <!-- Fin de la Barre de navigation -->

   <!-- Header -->
   <header>
        <h1>Ego sum via veritas et vita</h1>
   </header>
   <!-- Fin du Header -->

<div class ="container">
<br>
<div class="Articles_à_la_une">
    <p>Articles à la une</p>
</div>

  <section class="articles">
    <?php if($info_utilisateur) { ?>
    <h2><?= $info_utilisateur ?></h2>
    <?php } ?>

    <?php if($aucun_resultat) { ?>
    <h3>Aucun résultat ne correspond à votre recherche...</h3>
    <?php } ?>

    <?php while($a = $articles -> fetch(PDO::FETCH_ASSOC)) { ?>
    <div class="article">
     <div class="left">
     <div class="image-wrapper">
		     <a href="article.php?id=<?= $a['id'] ?>">
			<img src="images/miniatures/<?= $a['id'] ?>.jpg" alt="<?= $a['titre'] ?>">
		</a>
	</div>
     </div>
     <div class="right">
       <p class="date"><?= $a['date_formatee'] ?></p>
       <p class="categorie"><?= getNomCategorie($a['categorie']) ?></p>
       <h1><?= $a['titre'] ?></a></h1>
       <p class="description"><?= substr(strip_tags(htmlspecialchars_decode($a['contenu'])), 0, 100).'...' ?></p>
       <p class="auteur">Le Christ Blagueur</p>
     </div>
   </div> 
   <?php } ?>
 </section>

 <br>
 <div class="Mes_Vidéos">
    <p>Mes vidéos</p>
</div>

 <section class="vidéos">
    <div class="vidéo">
     <div class="left">
     <iframe src="https://youtube.com/embed/HBe4UD1tsy4" alt="miniature"></iframe>
     </div>
     <div class="right">
       <p class="date">19 novembre 2021</p>
       <h1>L'heure du jugement ! Les arguments anti-chasse, débunkage d'une fumisterie</h1>
       <p class="description">Vous en avez marre de lire ou d'entendre toujours les mêmes bêtises contre la chasse ? Moi aussi.
C'est pour ça que j'ai pris le temps de réaliser cette petite (grosse) vidéo, réponse directe à ceux-ci</p>
       <p class="auteur">Le Christ Blagueur</p>
     </div>
   </div> 
   
   
   <div class="vidéo">
     <div class="left">
     <iframe src="https://www.youtube.com/embed/w5BlLtipM5M" alt="miniature"></iframe>
     </div>
     <div class="right">
       <p class="date">2 mars 2022</p>
       <h1>Jésus réinforme-nous : Les vaccins</h1>
       <p class="description">On traite du sujet des vaccins. 
           On aborde plusieurs notions comme : Qu’est-ce que l’immunité, comment l’acquérir, comment fonctionne les vaccins, d’où vient l’ARNm, etc. 
           Cette vidéo a pour but de dénoncer, de réfuter, et de tourner en dérision les informations incorrectes liées à la vaccination</p>
       <p class="auteur">Le Christ Blagueur</p>
     </div>
   </div>
   
   <div class="vidéo">
     <div class="left">
     <iframe src="https://youtube.com/embed/tw7YPLsrP6M" alt="miniature"></iframe>
     </div>
     <div class="right">
       <p class="date">15 mars 2022</p>
       <h1>Ces historiens ne débunkent PAS Zemmour</h1>
       <p class="description">Je réponds à la vidéo de Manon Bril où un collectif d'historiens prétend débunker Eric Zemmour (mon oeil)</p>
       <p class="auteur">Le Christ Blagueur</p>
     </div>
   </div>
 </section>
</div>

   <!-- Pied de page -->
   <footer>
    <p>Le Christ Blagueur, France</p>
       <div class="social-media">
           <a href="https://twitter.com/ChristBlagueur2" target="_blank"><i class="fa-brands fa-twitter"></i></a>
           <a href="https://www.instagram.com/lechristblagueur/" target="_blank"><i class="fa-brands fa-instagram"></i></a>
           <a href="https://gettr.com/user/christblagueur" target="_blank">GETTR</a>
           <a href="https://www.youtube.com/channel/UCCGKzn9hRGbrSO3rHCF82eQ" target="_blank"><i class="fa-brands fa-youtube"></i></a>
       </div>
</footer>
   <!-- Fin du Pied de page -->
</section>
</body>
</html>

