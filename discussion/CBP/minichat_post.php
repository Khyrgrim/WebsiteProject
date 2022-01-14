<?php 
setcookie('author', htmlspecialchars($_POST['author']), time() + 3600*24*7, null, null, false); // Créer un nouveau cookie pour retenir le pseudo de l'utilisateur sécurisé (!XSS).
setcookie('chsndate', htmlspecialchars($_POST['chsndate']), time() + 10, null, null, false); // Crée un cookie pour les gens voulant afficher les messages d'un jour précédent.
setcookie('subject', htmlspecialchars($_POST['subject']), time() + 3600*8, null, null, false); // Crée un cookie pour les gens voulant afficher les messages d'un jour précédent.
if ($_POST['subject']=="all") {$_POST['subject']="general";}

 ?>

<?php
// Connexion à la base de données
try {
    $bdd=new PDO("mysql:host=sql.free.fr; dbname=nicard_cyril;charset=utf8", 'nicard.cyril', 'freekhyrgrim2503');
}
catch(Exception $e) {
        die('Erreur : '.$e->getMessage());
}


if ($_POST['author']!='' && $_POST['msg']!='') { // Vérifie que le pseudo et le message sont remplient avant d'envoyer les requêtes à la bdd.
	$req = $bdd->prepare('INSERT INTO minichat (author, msg, msgdate,msgtime,subject) VALUES( ?, ?, CURDATE(), CURTIME(), ? )'); // Insertion du message à l'aide d'une requête préparée
	$req->execute(array(htmlspecialchars($_POST['author']), htmlspecialchars($_POST['msg']), htmlspecialchars($_POST['subject']) ));
}

// Redirection du visiteur vers la page du minichat
echo '<script language="Javascript">
           <!--
                 document.location.replace("minichat.php");
           // -->
     </script>';
?>