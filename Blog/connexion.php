<?php 
session_start();

if(isset($_SESSION['admin']) AND $_SESSION['admin']) {
    header('Location: /administration.php'); 
}

$erreur = '';
if(isset($_POST['connexion'])) {
    if(isset($_POST['pseudo'], $_POST['mdp'])) {
       $pseudo = htmlspecialchars($_POST['pseudo']);
       $mdp=htmlspecialchars($_POST['mdp']);
    
    if(!empty($pseudo) AND !empty($mdp)) {

        if(($pseudo == 'Le_christ_blagueur' AND $mdp == 'FfZvQmXe38;//') OR ($pseudo =='admin' AND $mdp =='6c2C)z.a4W')) {
            $_SESSION['admin'] = true;
            header('Location: /administration.php');
        } else {
            $erreur ='Les identifiants que vous avez saisi sont invalides';
        }

      } else {
        $erreur = 'Veuillez saisir votre nom d\'utilisateur et votre mot de passe';
      }
   } else {
       $erreur = 'Veuillez saisir votre nom d\'utilisateur et votre mot de passe';
   }
}
?>
<!DOCTYPE html>
<html>
    <head>
  <title>Connexion</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <script src="https://kit.fontawesome.com/8e87ace701.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css"/>
    </head>
    <body>
<section class="page">
<?php include_once 'includes/navi.php' ?>

<h2>Connexion</h2>
<form method="POST">
    <input type="text" placeholder="Nom d'utilisateur" name="pseudo" <?php if
    (isset($pseudo)) { ?> value="<?=$pseudo ?>" <?php } ?>> 
    <br>
    <input type="password" placeholder="Mot de passe" name="mdp" <?php if
    (isset($mdp)) { ?> value="<?=$mdp ?>" <?php } ?>>
    <br>
    <input type ="submit" name="connexion" value="Se connecter">
</form>
<?php if($erreur) { ?>
    <p style="color: red;"><?= $erreur ?></p>
<?php } ?>

<?php include_once 'includes/foot.php' ?>
</section>
</body>
</html>

