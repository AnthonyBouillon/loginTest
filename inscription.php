<?php
/* * * A faire comme vérification
 *       Le pseudonyme demandé par le visiteur est-il libre ? S'il est déjà présent en base de données, il faudra demander au visiteur d'en choisir un autre.
  Les deux mots de passe saisis sont-ils identiques ? S'il y a une erreur, il faut inviter le visiteur à rentrer à nouveau le mot de passe.
  L'adresse e-mail a-t-elle une forme valide ? Vous pouvez utiliser une expression régulière pour le vérifier. */
session_start();
  if(!empty($_SESSION['pseudo'])){
$_SESSION['pseudo'];
  }
try {
    $bdd = new PDO("mysql:host=127.0.0.1;dbname=membres;charset=utf8", "root", "789789");
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
if (!empty($_POST['pseudo'])) {
   $reponse = $bdd->query('SELECT pseudo FROM membres WHERE pseudo=\'' . $_POST['pseudo'] . '\'');
     
    if ($donnees = $reponse->fetch())
    {
        echo 'Il y a déjà une personne qui utilise '.$_POST['pseudo'] .' comme pseudo !<br />';
    }
    else
    {
       echo 'le pseudo est libre';
    }
    
     }

    
    
// INSERE LES DONNÉE DU FORMULAIRE
if (!empty($_POST['pseudo']) && !empty($_POST['pass']) && !empty($_POST['email'])) {
    $pseudo = $_POST['pseudo'];
    $pass_hach = password_hash($_POST['pass'], PASSWORD_DEFAULT);
    $email = $_POST['email'];
    // Insertion
    $req = $bdd->prepare('INSERT INTO `membres`(`pseudo`, `pass`, `email`) VALUES(\'' . $pseudo . '\',\'' . $pass_hach . '\', \'' . $email . '\') ');
    $req->execute();
}

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
        <title>Inscription</title>
    </head>
    <body>
        <h1 class="text-center">FORMULAIRE D'INSCRIPTION</h1><br/><br/>
        <?php
                if(!empty($_SESSION['pseudo'])){
            echo 'Vous êtes connecté ' . $_SESSION['pseudo'];
                }
        ?>
         <p><a href="deconnexion.php">deconnexion</a></p>
        <p><a href="connexion.php">Connexion</a></p>
        <form method="POST">
            <label class="control-label col-sm-2" for="pseudo">Pseudo : </label>
            <input type="text" class="form-control" id="pseudo" name="pseudo" placeholder="Enter username">

            <label class="control-label col-sm-2" for="pwd">Mot de passe : </label>
            <input type="password" class="form-control" id="pwd" name="pass" placeholder="Enter password">

            <label class="control-label col-sm-2" for="mail">Mail :</label>
            <input type="text" class="form-control" id="mail" name="email" placeholder="Enter mail">

            <button type="submit" class="btn btn-default">Submit</button>
        </form>  

        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </body>
</html>
