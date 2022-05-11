<?php
    include "db.php";
    $db = new database();

    if(isset($_GET['id'])){  try{
    $db->select("DELETE FROM medewerkers WHERE id = :id", ['id'=>$_GET['id']],[]); }
    catch(Exception $e) {
        echo 'MEDEWERKER IS BEZIG'; header("refresh:3; gebruiksbeheer.php"); exit;}

    echo "<strong>verwijderen gelukt</strong>";

    header("refresh:2; gebruiksbeheer.php");
    }
?>