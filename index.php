<?php 
 include 'db.php';
$db = new database();

$db->insert_first_user();

//login functie
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['inloggen'])){

   // als velden niet zijn ingevuld gaat de code niet door
   if (!empty($_POST["emailadres"] && !empty($_POST["wachtwoord"]))) {

      $emailadres = $_POST['emailadres'];
      $wachtwoord = $_POST['wachtwoord'];  

      $db = new database();

      $db->inloggen($emailadres, $wachtwoord);

   }else{
      echo "Bijde velden moeten ingevuld zijn, probeer nogmaals";
   }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inloggen</title>
</head>
<body>
    
    <form method="post">
        <label>Emailadres</label>
        <br>
        <input type="emailadres" name="emailadres">
        <br><br>
        <label>Wachtwoord</label>
        <br>
        <input type="wachtwoord" name="wachtwoord">
        <button type="submit" name="inloggen">Inloggen</button>
    </form>
</body>
</html>