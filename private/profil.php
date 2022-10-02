<?php
// on démarre la session
session_start();

// on ferme la session si l'utilisateur est connecté et si $_GET['deconnexion'] est défini et = à true
if (isset($_GET['deconnexion']) && $_GET['deconnexion'] == 1) {
    // on détruit la session
    session_destroy();
}

// on verifie si l'utilisateur est connecté via le session username
if (isset($_SESSION['username'])) {
    // on passe le username et le password en variable de session
    $user = $_SESSION['username'];
    // on vérifie que les données du textearea sont définies
    if (isset($_POST['textearea']) && !empty($_POST['textearea'])) {
        // on récupère le textearea
        $textearea = $_POST['textearea'];

        // on se connecte à la base de données
        $db = new PDO('mysql:host=localhost;dbname=journal;charset=utf8', 'root', 'lannion');

        // on vérifie si l'utilisateur existe dans la base de données
        $req = $db->prepare('SELECT * FROM users WHERE username = :username');

        // on execute la requête
        $req->execute(array(
            'username' => $user
        ));

        // on vérifie que la requête retourne au moins un résultat
        if ($req->rowCount() > 0) {
            // on update les la donnée du texte area de l'utilisateur dans la base de données
            $req = $db->prepare('UPDATE users SET textarea = :textarea WHERE username = :username');

            // on execute la requête
            $req->execute(array(
                'textarea' => $_POST['textarea'],
                'username' => $user
            ));
        } else {
            // on insert l'utilisateur dans la base de données avec les données de la session username et le textearea de la page profil.php
            $req = $db->prepare('INSERT INTO users(username, textarea) VALUES(:username, :textarea)');

            // on execute la requête
            $req->execute(array(
                'username' => $user,
                'textarea' => $_POST['textarea']
            ));
        }
    }
    
} else {
    // on redirige vers la page de connexion
    header('Location: ../login.php');
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
            <!-- bouton pour se déconnecter de la session -->
            <a href="profil.php?deconnexion=true">Se déconnecter</a>
        </div>
    </header>
    <main>
        <div class="cadre">
            <form action="" method="post">
                <textarea name="pensez" id="pensez" cols="30" rows="10"></textarea>
                <input type="submit" value="Enregistrer">
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