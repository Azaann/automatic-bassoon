<?php 

class database{
    
    private $db_server;
    private $db_username;
    private $db_password;
    private $db_name;
    private $db;

    // Functie voor het connecteren met de database
    function __construct(){

        $this->db_server = 'localhost';
        $this->db_username = 'root';
        $this->db_password = '';
        $this->db_name = 'examen';

        $dsn = "mysql:host=$this->db_server;dbname=$this->db_name;charset=utf8mb4";

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
             $this->db = new PDO($dsn, $this->db_username, $this->db_password, $options);
        } catch (\PDOException $e) {
             throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    // Functie voor het opzoeken van data
	public function select($statement, $named_placeholder){

        // prepared statement (Stuurt statement naar de server + checks syntax)
        $statement = $this->db->prepare($statement);

        $statement->execute($named_placeholder);
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    //<-------------------------( Functie inloggen )------------------------->

    public function inloggen($emailadres, $wachtwoord) {

        $sql = "SELECT * FROM medewerkers WHERE emailadres = :emailadres";

        $statement = $this->db->prepare($sql);

        $statement->execute(['emailadres' => $emailadres]); 
     
        $result = $statement->fetch();

        if (is_array($result) && count($result) > 0) {

            $hashed_password = $result['wachtwoord'];

            
            if ($emailadres && password_verify($wachtwoord, $hashed_password)) {

                session_start();
                // save userdata in session variables
                $_SESSION['id'] = $result['id'];
                $_SESSION['rolid'] = $result['rolid'];
                $_SESSION['naam'] = $result['naam'];
                $_SESSION['emailadres'] = $result['emailadres'];
                
                $_SESSION['loggedin'] = true;
                
                echo "<strong>Inloggen gelukt</strong>";

                header("refresh:2; dashboard.php");
                     
            }else{
                echo "<strong>Wachtwoord of email incorrect</strong>";
            }

        }else{
            echo "<strong>Gebruiker bestaat niet</strong>";
        }   
    }
    //<-------------------------( Admin aanmaken )------------------------->

    public function insert_first_user() {

        try{
            $hashed_password = password_hash('123', PASSWORD_DEFAULT);

            $sql = "INSERT IGNORE INTO medewerkers VALUES (NULL, :rolid, :naam, :wachtwoord, :emailadres)";

            // start database transactie
            $this->db->beginTransaction();

            // create PDOStatementObject and execute
            $statement = $this->db->prepare($sql);
            $statement->execute([
            'rolid' => '1',
            'naam' => "Azaan",
            'wachtwoord' => $hashed_password,
            'emailadres' => "az@gmail.com"
            ]);

            // commit database changes
            $this->db->commit();
            

        }catch (Exception $e){
            // undo databasechanges in geval van error
            $this->db->rollback();
            throw $e;
        }
    }   public function toevoegen($naam,$rolid,$hashed_password,$emailadres) {

        try{

            $sql = "INSERT IGNORE INTO medewerkers VALUES (NULL, :rolid, :naam, :wachtwoord, :emailadres)";

            // start database transactie
            $this->db->beginTransaction();

            // create PDOStatementObject and execute
            $statement = $this->db->prepare($sql);
            $statement->execute([
                'naam'=>$naam,
                'rolid'=>$rolid,
                'wachtwoord'=>$hashed_password,
                'emailadres'=>$emailadres
            ]);

            // commit database changes
            $this->db->commit();
            

        }catch (Exception $e){
            // undo databasechanges in geval van error
            $this->db->rollback();
            throw $e;
        }

                header("refresh:0; gebruiksbeheer.php");
    }
    public function toevoegene($sql, $named_placeholder, $location){
        $stmt = $this->db->prepare($sql);
        $stmt->execute($named_placeholder);
        header('location:'.$location);
        exit();
    }

 //<-------------------------( Medewerker wijzigen )------------------------->

 public function wijzigen($sql, $named_placeholder) {

    try{
        $hashed_password = password_hash('123', PASSWORD_DEFAULT);

        $sql = "UPDATE medewerkers SET rolid = :rolid, naam = :naam, emailadres = :emailadres WHERE id = :id";

        // start database transactie
        $this->db->beginTransaction();

        // create PDOStatementObject and execute
        $statement = $this->db->prepare($sql);
        $statement->execute([
           'id'=>$_POST['id'],
            'naam'=>$_POST['naam'],
            'rolid'=>$_POST['rolid'],
            'emailadres'=>$_POST['emailadres']
        ]);

        // commit database changes
        if ($this->db->commit()) {
        }

    }catch (Exception $e){
        // undo databasechanges in geval van error
        $this->db->rollback();
        throw $e;
    }
    echo "<strong>wijzigen gelukt</strong>";

    header("refresh:2; gebruiksbeheer.php");

}}
?>
