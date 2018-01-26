<?php
  session_start();
if(isset($_SESSION['pseudo'])){
    $_SESSION['pseudo'];
}
 
try {
    $bdd = new PDO("mysql:host=127.0.0.1;dbname=membres;charset=utf8", "root", "789789");
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

if (!empty($_POST['pseudo']) && !empty($_POST['pass'])){
$pass= $_POST['pass'];
$pseudo = $_POST['pseudo'];
// Vérification des identifiants
$req = $bdd->prepare('SELECT id, pass, pseudo FROM membres WHERE pseudo = \'' . $pseudo . '\' ');
$req->execute();
$resultat = $req->fetch();

if (password_verify($pass, $resultat['pass']))
{
    $_SESSION['id'] = $resultat['id'];
    $_SESSION['pseudo'] = $pseudo;    
}
else
{
    echo 'Mauvais identifiant ou mot de passe !';
}
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
        <p><a href="deconnexion.php">deconnexion</a></p>
        <p><a href="inscription.php">Inscription</a></p>
        <form method="POST">
            <?php
        if (isset($_SESSION['pseudo'])) {
            echo 'Vous êtes connecté ' . $_SESSION['pseudo'];
        }
        ?>
            <label class="control-label col-sm-2" for="pseudo">Pseudo : </label>
            <input type="text" class="form-control" id="pseudo" name="pseudo" placeholder="Enter username">

            <label class="control-label col-sm-2" for="pwd">Mot de passe : </label>
            <input type="password" class="form-control" id="pwd" name="pass" placeholder="Enter password">

            <button type="submit" class="btn btn-default">Submit</button>
        </form>  

        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </body>
</html>