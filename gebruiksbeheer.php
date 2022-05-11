<?php
include 'db.php';
session_start();
$db = new database();

$gebruikers_beheer = $db->select("SELECT * FROM medewerkers",[]);

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['medewerker_wijzigen'])){

    $medewerker_id = htmlspecialchars(trim($_POST['medewerker_id']));
    $medewerker_rol = htmlspecialchars(trim($_POST['medewerker_rol']));
    $medewerker_naam = htmlspecialchars(trim($_POST['medewerker_naam']));
    $medewerker_email = htmlspecialchars(trim($_POST['medewerker_email']));
  
    $db = new database();
  
      $db->wijzigen($medewerker_id, $medewerker_rol, $medewerker_naam, $medewerker_email);
  
  
  }
  if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['afdrukken'])) {

    $bon_details = $db->select("SELECT * FROM medewerkers",[]);
    

    $filename = "bon-datum-".date('Y-m-d')."";

    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=\"$filename\"");
    $print_header = false;

    if (!empty($bon_details)) {
        foreach($bon_details AS $details){
            if (!$print_header) {
                echo implode("\t", array_keys($details)) . "\n";
                $print_header = true;
            }
            echo implode("\t", array_values($details)) . "\n";
        }
        
    }

    exit;

}
 ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gebruikers beheer</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'navigation.php'; ?>
    <br><br><br><br><br>
    <br>
    <table>
    <thead>
            <tr>
                <th>Id</th>
                <th>Rol</th>
                <th>Naam</th>
                <th>Emailadres</th>
                <th>Opties</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($gebruikers_beheer as $gebruiker) { ?>

                <?php $huidig_rol = $db->select("SELECT rollen.id, rollen.naam FROM rollen LEFT JOIN medewerkers ON rollen.id = medewerkers.rolid WHERE medewerkers.id = :user_id",[':user_id' => $gebruiker['id']]);?>

                <?php foreach ($huidig_rol as $rol) {} ?>
                <form method="POST">

                
                <tr>
                    <td>
                    <input type="text" name="medewerker_id" value="<?php echo $gebruiker['id'] ?> " disabled>
                    </td>

                    <td>
                        <select name="medewerker_rol">
                            <option value="<?php echo $rol['id']?>"><?php echo $rol['naam'] ?></option>
                            <option value="1">Admin</option>
                            <option value="2">Inname</option>
                            <option value="3">Uitgifte</option>
                            <option value="4">Verwerking</option>
                            <option value="5">Algemeen</option>
                            <option value="2">Applicatie beheerder</option>
                        </select>
                    </td>
                    <td>
                        <input type="text" name="medewerker_naam" value="<?php echo $gebruiker['naam'] ?>">
                    </td>
                    <td>
                        <input type="email" name="medewerker_email" value="<?php echo $gebruiker['emailadres'] ?>">
                    </td>
                    <td>
                        <a href="gebruikerverwijderen.php?id=<?php echo $gebruiker['id'] ?>">verwijder</a>
                        <br>
                        <a href="gebruikerwijzigen.php?id=<?php echo $gebruiker['id'] ?>">wijzig</a>
                        <button type="submit" name="wijzigen">Wijzig</button>
                    </td>
                </tr>
            </form>
            <?php } ?>
        </tbody>
    </table>
    <form method="post">
        <button type="submit" name="afdrukken">Afdrukken</button>
    </form>
    <a href='gebruikertoevoegen.php'> gebruiker toevoegen </a>

</body>
</html>