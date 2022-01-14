<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Minichat</title>
        <meta name='author' content="Khyrgrim, France">
        <script type="application/x-javascript">

            document.addEventListener('keydown',Keydown,false);
            document.addEventListener('keyup',Keyup,false);
            document.addEventListener('click',Click,false);

            var lastactiontime = Date.now();
            var refreshdelay = 1000*60*5 ;
            var actualtime = Date.now();
            var delay = 0;

            function Keydown(ev) {
            lastactiontime = Date.now();
            }

            function Keyup(ev) {
            lastactiontime = Date.now();
            }

            function Click(ev)  {
            astactiontime = Date.now();
            }
        
            function Step(){
            actualtime = Date.now();
            delay = actualtime-lastactiontime;
            if (delay>refreshdelay) { document.location.href="http://nicard.cyril.free.fr/discussion/CBP/minichat.php" }

            setTimeout(Step,1000*60);
            }

        </script>

        <?php
            if(isset($_COOKIE['author'])) {$_author = $_COOKIE['author'];} // Vérifie si le cookie existe
            else {$_author="";} // Si le cookie n'existe pas ... 

            if(isset($_COOKIE['subject'])) {$_subject = $_COOKIE['subject'];} // Vérifie si le cookie existe
            else {$_subject="general";} // Si le cookie n'existe pas ...

            if(isset($_COOKIE['chsndate'])) {$_chsndate = $_COOKIE['chsndate'];} // Vérifie si le cookie existe
            else {$_chsndate=date('Y-m-d');} // Si le cookie n'existe pas ...
        ?>


    </head>
        
    <form action="minichat_post.php" method="post">
        <p>
        <label for="author">Author</label> : <input type="text" name="author" id="author" value=    
            <?php 
            echo '"'. $_author .'"';
            ?>     
        /> <br />
        <label for="subject">Subject : </label>
            <select name="subject" id="subject">
                <option value="general" <?php if($_subject=="general")  {echo " selected";} ?> >General</option>
                <option value="games" <?php if($_subject=="games")  {echo " selected";} ?> >Games</option>
                <option value="cinema" <?php if($_subject=="cinema")  {echo " selected";} ?> >Cinema</option>
                <option value="music" <?php if($_subject=="music")  {echo " selected";} ?> >Music</option>
                <option value="vegan" <?php if($_subject=="vegan")  {echo " selected";} ?> >Vegan</option>
                <option value="all" <?php if($_subject=="all")  {echo " selected";} ?> >All</option>
            </select> <br />
        
        <label for="msg">Message</label> : <br /> <textarea name="msg" rows="2" cols="50"></textarea> <br /><br />

        <input type="submit" value="Send / Refresh" /> <br /><br />
        
        <label for="Date">Date (Today by default)</label> : <input type="date" name="chsndate" id="chsndate" value=<?php 
            echo '"'. $_chsndate . '"';
            ?>   /> <br />

	</p>
    </form>



<body style='margin:0; padding:0;' onload='Step()' >
<?php
// Connexion à la base de données
try {
	$bdd=new PDO("mysql:host=sql.free.fr; dbname=nicard_cyril;charset=utf8", 'nicard.cyril', 'freekhyrgrim2503');
}
catch(Exception $e) {
        die('Erreur : '.$e->getMessage());
}

// $reponse = $bdd->query('SELECT author, msg, DATE_FORMAT(msgdate, \'%d/%m/%y \') AS date_fr , msgtime FROM minichat WHERE msgdate=CURDATE() ORDER BY ID DESC LIMIT 0, 1000');

if($_subject!='all') {
    echo '<p>'.'Date : '. $_chsndate . ' ; Subject : '. $_subject . '</p>';
    $req = $bdd->prepare('SELECT author, msg, DATE_FORMAT(msgdate, \'%d/%m/%y \') AS date_fr , msgtime, subject FROM minichat WHERE msgdate=? AND subject=?  ORDER BY ID DESC LIMIT 0, 1000');
    $req->execute(array($_chsndate,$_subject));
}
else {
    echo '<p>'.'Date : '. $_chsndate . ' ; Subject : '. $_subject . '</p>';
    $req = $bdd->prepare('SELECT author, msg, DATE_FORMAT(msgdate, \'%d/%m/%y \') AS date_fr , msgtime, subject FROM minichat WHERE msgdate=? ORDER BY ID DESC LIMIT 0, 1000');
    $req->execute(array($_chsndate));
}

// Récupération des 10 derniers messages


// Affichage de chaque message avec la date et l'auteur (toutes les données sont protégées par htmlspecialchars)
while ($donnees = $req->fetch())
{
	echo '<p> - '.htmlspecialchars($donnees['date_fr']).' à '.htmlspecialchars($donnees['msgtime']).' - '. htmlspecialchars($donnees['subject']) . '<strong> - ' . htmlspecialchars($donnees['author']) . '</strong> : <br />' . nl2br($donnees['msg']) . '</p>';
}

$req->closeCursor();

?>
    </body>
</html>