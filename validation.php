<?php

// on vérifie que le usrname et le password soit dans l'url
if (isset($_GET['mail']) && isset($_GET['code'])) {
    // on récupère les données envoyer par mail et on les stocke dans des variables
    $mail = htmlentities($_GET['mail']);
    $password = htmlentities($_GET['code']);

    // on vérifie que l'utilisateur existe dans la base de donnée et que le code de validation est à false (0) 
    $bdd = new PDO('mysql:host=localhost;dbname=journal;charset=utf8', 'root', 'lannion');
    $req = $bdd->prepare('SELECT * FROM _user WHERE mail = :mail AND active = 0');
    $req->execute(array(
        'mail' => $mail
    ));
    $resultat = $req->fetch();
    // on vérifie que l'utilisateur existe dans la base de donnée et que le code de validation est à false (0) 
    if ($resultat) {
        // on vérifie que le code de validation est bon
        if ($resultat['code_activation'] == $password) {
            // on met la variable validation à true (1)
            $req2 = $bdd->prepare('UPDATE _user SET active = 1 WHERE mail = :mail');
            $req2->execute(array(
                'mail' => $mail
            ));
            // on affiche un message de confirmation
            $msg = 'Votre compte a bien été validé !';
	    header('http://localhost/login.php');
        } else {
            // on affiche un message d'erreur
            $msg = 'Le code de validation est incorrect !';
        }
    } else {
        // on affiche un message d'erreur
        $msg = 'Cet utilisateur n\'existe pas ou est déjà validé !';
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Journal Secret</title>

    <link rel="stylesheet" href="src/sass/main.css">

</head>

<body>
    <header>
        <h1><a href="index.html">Mon Journal Secret</a></h1>
        <div class="boutons">
            <a href="login.html">Se Connecter</a>
            <a href="inscrire.html">S'inscrire</a>
        </div>
    </header>
    <main>
        <div class="cadre">
            <div class="writing">
                <p>
                    <?php
                    // on affiche le message de validation si les variables sont dans l'url

                     echo $msg;
                
                    ?>
                </p>
            </div>
            <div class="btn">
                <a href="private/profil.php">Écrire</a>
            </div>
        </div>
    </main>
    <footer>
        <div class="copyright">
            <h2>Mon Journal Secret</h2>
            <p>Copyright © 2022 - Tous droits réservés</p>
        </div>
        <div class="ressource">
            <h2>Ressources</h2>
            <p>Ce site à été développé entièrement par l'équipe G21 par leur propre soin.</p>
        </div>
        <div class="follow">
            <h2>Suivez-nous</h2>
            <div class="follow-icons">
                <a href="#"><img src="src/img/facebook.png" alt="facebook"></a>
                <a href="#"><img src="src/img/twitter.png" alt="twitter"></a>
                <a href="#"><img src="src/img/youtube.png" alt="youtube"></a>
            </div>
        </div>
        <h1>Mon Journal Secret</h1>
    </footer>
</body>

</html>