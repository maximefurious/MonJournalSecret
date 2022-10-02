<?php
// commencer la session
session_start();

if (isset($_POST['mail'])) {

    // on récupère les données du formulaire
    $mail = htmlspecialchars($_POST['mail']);
    $password = $_POST['password'];

    // on se connecte à la base de données
    $bdd = new PDO('mysql:host=localhost;dbname=journal;charset=utf8', 'root', 'lannion');

    // on récupère les données de l'utilisateur
    $req = $bdd->prepare('SELECT * FROM _user WHERE mail = :mail');
    $req->execute([
        'mail' => $mail
    ]);

    // on vérifie si l'utilisateur existe
    if ($req->rowCount() > 0) {

        // on récupère les données de l'utilisateur
        $donnees = $req->fetch();
        die("coucou");
	echo password_verify(sha1($password), $donnees['pwd']);
        // on vérifie si le mot de passe est correct
        if (password_verify(sha1($password), $donnees['pwd'])) {
            // on démarre la session
            $_SESSION['mail'] = $mail;

            // on redirige l'utilisateur vers la page d'accueil
            die("coucou");
            header('Location: profil.php');
	    exit();
        } else {
            $erreur = 'Mot de passe incorrect';
        }
    } else {
        $erreur = 'Utilisateur inconnu';
    }
} else {
    $erreur = 'Veuillez remplir tous les champs';
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
        <h1><a href="index.php">Mon Journal Secret</a></h1>
        <div class="boutons">
            <a href="login.php">Se Connecter</a>
            <a href="inscrire.php">S'inscrire</a>
        </div>
    </header>
    <main>
        <div class="cadre">
            <form action="" method="post" class="inscrire">
                <h1>Connectez-vous !</h1>
                <div class="form-group">
                    <input type="email" name="mail" id="mail" class="form-control" placeholder="userame" required autocomplete="none">
                </div>
                <div class="form-group">
                    <input type="password" name="password" id="password" class="form-control" placeholder="password" required autocomplete="none">
                </div>
                <input type="submit" value="S'inscrire" class="btn btn-primary">
		<?php echo $erreur ?>
            </form>
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