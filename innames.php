<?php session_start();
include 'db.php';
$db = new database(); if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['afdrukken'])) {
$totaal = 0;
$bon_details = $db->select("SELECT apparaten.naam AS naam, apparaten.vergoeding, medewerkers.naam AS medewerkernaam, innames.id FROM innameapparaat INNER JOIN apparaten ON innameapparaat.apparaatid = apparaten.id INNER JOIN innames on innameapparaat.innameid = innames.id INNER JOIN medewerkers ON innames.medewerkerid = medewerkers.id;",[]);
    foreach($bon_details AS $details){
        $totaal += $details["vergoeding"];
    };

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
    echo "Totaal = € " .$totaal;

}

exit;

} ?>

<html>
<link rel="stylesheet" href="style.css">
<?php 
include 'navigation.php';
$db = new database();
$innames = $db->select("SELECT apparaten.naam AS naam, apparaten.vergoeding, medewerkers.naam AS medewerkernaam, innames.id FROM innameapparaat INNER JOIN apparaten ON innameapparaat.apparaatid = apparaten.id INNER JOIN innames on innameapparaat.innameid = innames.id INNER JOIN medewerkers ON innames.medewerkerid = medewerkers.id;;
", []);
?>
<h1> apparaten en vergoeding </h1>
<table style="width:45%;"> 
    <thead>
        <tr>
            <th> id</th> 
            <th> apparaat</th> 
            <th> vergoeding </th>
        </tr>
    </thead>
    <tbody>
    <?php
if ($innames) {
    foreach ($innames as $inname) { ?>
    <tr>    
        <td> <?php echo $inname['id'] ?> </td>
        <td> <?php echo $inname['naam'] ?> </td>
        <td> <?php echo $inname['vergoeding']?> </td>
    </tr>
   <?php }
} else {
    // geen apparaten
    echo 'Error';
}
?>
    <form method="post">
        <button type="submit" name="afdrukken">Afdrukken</button>
    </form>
        
    </tbody>
</table>

<table style="float:right;width:45%;top:155px;right:0;position:absolute;" > 
    <thead>
        <tr>
            <th> medewerker</th> 
            <th> apparaat</th> 
            <th> vergoeding </th>
        </tr>
    </thead>
    <tbody>
    <?php
if ($innames) {
    foreach ($innames as $inname) { ?>
    <tr>    
        <td> <?php echo $inname['medewerkernaam'] ?> </td>
        <td> <?php echo $inname['naam'] ?> </td>
        <td> <?php echo $inname['vergoeding']?> </td>
    </tr>
   <?php }
} else {
    // geen apparaten
    echo 'Error';
}
?>
        
    </tbody>
</table>


</html>
