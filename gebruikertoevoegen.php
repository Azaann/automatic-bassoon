<?php
    include "db.php";

        $db = new database();
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $naam = $_POST['naam'];
            $rolid = $_POST['rolid'];
            $wachtwoord = $_POST['wachtwoord'];
            $hashed_password = password_hash($wachtwoord, PASSWORD_DEFAULT);
            $emailadres = $_POST['emailadres'];

            $sql = "INSERT INTO medewerkers VALUES (NULL, :naam, :rolid, :wachtwoord, :emailadres)";
            $placeholder = [
                'naam'=>$naam,
                'rolid'=>$rolid,
                'wachtwoord'=>$hashed_password,
                'emailadres'=>$emailadres
            ];
            $db->toevoegen($naam,$rolid,$hashed_password,$emailadres);
        }
        $school = $db->select("SELECT id, naam FROM medewerkers", []);
    ?>
    <form action="" method="post">
    
        <input type="text" name="naam" placeholder="naam" required> 
        <input type="number" name="rolid" id="rolid" required>
        <input type="password" name="wachtwoord" placeholder="wachtwoord" required> 
        <input type="text" name="emailadres" placeholder="emailadres" required> 
        <input type="submit" value="voeg medewerker toe">
    </form>
</body>
</html>