<?php
session_start();
$mail = $_SESSION['mail'];
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

                     echo $mail;
                
                    ?>
                </p>
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