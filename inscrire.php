<?php
session_start();
$msg = ' ';
// on récupère le mail et le password
if (isset($_POST['mail']) && isset($_POST['password'])) {
    $mail = htmlspecialchars($_POST['mail']);
    $password = htmlspecialchars($_POST['password']);

    if (preg_match("!^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$!", $mail)) // Verifie que l'email entrée n'est pas une fausse.
    {
        // on se connecte à MySQL avec pdo (connexion à la base de données)
        $bdd = new PDO('mysql:host=localhost;dbname=journal;charset=utf8', 'root', 'lannion');
        // on vérifie que le mail n'est pas déjà utilisé
        $req = $bdd->prepare('SELECT * FROM _user WHERE mail = :mail');
        $req->execute(array(
            'mail' => $mail
        ));
        $resultat = $req->fetch();

        if ($resultat) {
            $msg = 'Cet email est déjà utilisé';
        } else {
            // on génère une chaine aléatoire 
            $chaine = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
            $code = "";
            for ($i = 0; $i < 10; $i++) {
                $code .= $chaine[rand(0, strlen($chaine) - 1)];
            }
            // on ajoute l'utilisateur dans la base de données
            $req = $bdd->prepare('INSERT INTO _user(mail, pwd,date_inscription, code_activation) VALUES(:mail, :password, NOW(), :code)');
            $req->execute(array(
                'mail' => $mail,
                'password' => sha1($password),
                'code' => $code
            ));

            $msg = '<a href="http://localhost/validation.php?mail=' . $mail . '&code=' . $code. '">Cliquez ici pour valider votre compte</a>';
            $_SESSION['mail'] = $mail;
        }
    } else {
        $msg =  "Votre adresse mail n'est pas valide";
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
        <h1><a href="index.php">Mon Journal Secret</a></h1>
        <div class="boutons">
            <a href="login.php">Se Connecter</a>
            <a href="inscrire.php">S'inscrire</a>
        </div>
    </header>
    <main>
        <div class="cadre">
            <form action="" method="post" class="inscrire">
                <h1>Inscrivez-vous !</h1>
                <div class="form-group">
                    <input type="email" name="mail" id="mail" class="form-control" placeholder="userame" required autocomplete="none">
                </div>
                <div class="form-group">
                    <input type="password" name="password" id="password" class="form-control" placeholder="password" required autocomplete="none">
                </div>
                <div class="form-group">
                    <input type="password" name="password" id="password" class="form-control" placeholder="Confirmer password" required autocomplete="none">
                </div>
                <input type="submit" value="S'inscrire" class="btn btn-primary">
                <?php echo $msg; ?>
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