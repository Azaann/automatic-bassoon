<?php 
    include "db.php";
    $db = new database;

    if(isset($_GET['id'])){
        $gebruiker = $db->select("SELECT * FROM medewerkers WHERE id=:id",['id' => $_GET['id']]);
    }

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $sql = "UPDATE medewerkers SET id=:id, naam=:naam, rolid=:rolid, emailadres=:emailadres  WHERE id=:id";
    
        $placeholder = [
            'id'=>$_POST['id'],
            'naam'=>$_POST['naam'],
            'rolid'=>$_POST['rolid'],
            'emailadres'=>$_POST['emailadres']
        ];

    $db->wijzigen($sql, []);
    }
    $gebruikers = $db->select("SELECT * FROM medewerkers", []);
    ?>    

<form action="" method="post">
<input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : '' ?>">
<input type="text" name="naam" placeholder="naam" value="<?php echo isset($gebruiker) ? $gebruiker[0]['naam'] : ''?>">
<input type="text" name="rolid" placeholder="rolid" value="<?php echo isset($gebruiker) ? $gebruiker[0]['rolid'] : ''?>">
<input type="text" name="emailadres" placeholder="emailadres" value="<?php echo isset($gebruiker) ? $gebruiker[0]['emailadres'] : ''?>">
<input type="submit" value="Edit">
</form>