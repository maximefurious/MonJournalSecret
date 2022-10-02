<?php
// crontab -e 
// 0 2 * * * php /var/www/html/inscrire.php
// script qui permet de vérifier si un utilisateur à son compte validé ou non
// si non validé, on le supprime
// si validé, on ne fait rien

// connexion à la base de données
$bdd = new PDO('mysql:host=localhost;dbname=journal;charset=utf8', 'root', 'lannion');

// récupérer tout les utilisateurs
$req = $bdd->query('SELECT * FROM _user');

// parcourir tout les utilisateurs
while ($donnees = $req->fetch()) {
	if ($donnees['active'] == 0 && $donnees['date_inscription'] < date('Y-m-d H:i:s', strtotime('-1 day'))) {
		// supprimer l'utilisateur
		$req2 = $bdd->prepare('DELETE FROM _user WHERE id = :id');
		$req2->execute([
            'id' => $donnees['id']
        ]);
	}
}
?>