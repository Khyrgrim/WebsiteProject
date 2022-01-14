<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Quizz</title>
        <meta name='author' content="Khyrgrim, France">

        <?php
            if(isset($_POST['theme'])) {$_theme = $_POST['theme'];} // Vérifie si le post existe
            else {$_theme="all";} // Si le post n'existe pas ... On le crée

            if(isset($_POST['difficulty'])) {$_difficulty = $_POST['difficulty'];} // Vérifie si le post existe
            else {$_difficulty="3";} // Si le post n'existe pas ... On l'initialise'
        ?>


    </head>
        
    <form action="quizzform.php" method="post">
        <p>
        <label for="theme">Theme : </label>
            <select name="theme" id="theme">
                <option value="all" <?php if($_theme=="all")  {echo " selected";} ?> >All</option>
                <option value="geek" <?php if($_theme=="geek")  {echo " selected";} ?> >Geek</option>
                </select> <br />

        <label for="difficulty">Difficulty : </label>
            <select name="difficulty" id="difficulty">
                <option value="1" <?php if($_difficulty=="1")  {echo " selected";} ?> >1</option>
                <option value="2" <?php if($_difficulty=="2")  {echo " selected";} ?> >2</option>
                <option value="3" <?php if($_difficulty=="3")  {echo " selected";} ?> >3</option>
                <option value="4" <?php if($_difficulty=="4")  {echo " selected";} ?> >4</option>
                <option value="5" <?php if($_difficulty=="5")  {echo " selected";} ?> >5</option>
                <option value="6" <?php if($_difficulty=="6")  {echo " selected";} ?> >6</option>

            </select> <br />


        <input type="submit" value="Go !" /> <br /><br />

	</p>
    </form>



<body style='margin:5; padding:5;' onload='' >
<?php // Script pour obtenir les questions
    
    $rand = rand(1, 3300);
    $Qnumber = 1;
    $QRfull = fopen('QR01.txt', 'r');
    while ($Qnumber <= $rand)
		{
    		$Qtext = fgets($QRfull);
    		$Rtext = fgets($QRfull);
    		$Qnumber++;
		}
    fclose($QRfull);

	echo '<p>' . $saut . htmlspecialchars($Qtext) . "<br />" . "<br />" . htmlspecialchars($Rtext) . '</p>';

?>
    </body>
</html>