<?php
    
    class Database {


        private $servername = "mysql";
        private $username = "root";
        private $password = "root";
        private $privatedb = "user_login";
        private $dbname = "user_login";
        private $conn;


        //construct(zet database klaar)
        public function __construct()
        {
            try {
                $this->conn = new PDO("mysql:host={$this->servername};dbname={$this->dbname}", $this->username, $this->password);
                
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                // echo "Connected successfully";

            } catch(PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
            }
        }

        public function getConnection(){
            return $this->conn;
        }
        
        //haal data weer op
        public function getData() {

            try {
                
                $sql = "SELECT * FROM games";
                $stmt = $this->conn->prepare($sql);
                

                $stmt->execute();
                $retrieve_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $retrieve_data;
                echo"Data retrieved succesfully";

            } catch (PDOexception $e) {
                echo "Data retrieval failed." . $e->getMessage() . "<br>";
                return[];
            }
            
        }

    }
    
?>