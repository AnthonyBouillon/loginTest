<?php
session_start();
if (isset($_SESSION['pseudo'])) {
    $_SESSION['pseudo'];
}

// Connexion à la base de donnée
try {
    $bdd = new PDO("mysql:host=127.0.0.1;dbname=membres;charset=utf8", "utilisateur", "0000");
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}


// INSERE LES DONNÉES DU FORMULAIRE
if (!empty($_POST['pseudo']) && !empty($_POST['pass'])) {

    $pseudo = htmlspecialchars($_POST['pseudo']);
    $pass_hach = htmlspecialchars(password_hash($_POST['pass'], PASSWORD_DEFAULT));

    // Vérification de doublon de pseudo
    $req = $bdd->query('SELECT pseudo FROM membres WHERE pseudo=\'' . $pseudo . '\'');
    if ($donnees = $req->fetch()) {
        echo 'Il y a déjà une personne qui utilise ' . $pseudo . ' comme pseudo !<br />';
    } else {
        // Insertion
        $req = $bdd->prepare('INSERT INTO `membres`(`pseudo`, `pass`) VALUES(\'' . $pseudo . '\',\'' . $pass_hach . '\') ');
        $req->execute();
        $messageConfirmation = 'Vous êtes dorénavant Inscrit';
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
        <?php
        if (isset($_SESSION['pseudo'])) {
            echo 'Vous êtes connecté ' . $_SESSION['pseudo'];
        }
        ?>
        <p><a href="deconnexion.php">deconnexion</a></p>
        <p><a href="connexion.php">Connexion</a></p>

        <form method="POST">
            <label class="control-label col-sm-2" for="pseudo">Pseudo : </label>
            <input type="text" class="form-control" id="pseudo" name="pseudo" placeholder="Enter username" />

            <label class="control-label col-sm-2" for="pwd">Mot de passe : </label>
            <input type="password" class="form-control" id="pwd" name="pass" placeholder="Enter password" />


            <button type="submit" class="btn btn-default">Submit</button>
        </form>  

        <p class="text-center"><?php if (!empty($messageConfirmation)) {
            echo $messageConfirmation;
        } ?></p>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </body>
</html>
