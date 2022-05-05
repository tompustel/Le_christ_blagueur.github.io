
<?php 
require_once 'php/config.php';
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

   