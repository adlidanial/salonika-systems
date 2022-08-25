<?php

    class dbConnect
    {
        private $servername = "localhost";
        private $user = "root";
        private $pass = "admin";
        private $db = "salonika_systems";
        private $connect;

        public function connect()
        {
            try{
                $this->connect = new PDO("mysql:host=".$this->servername.";dbname=".$this->db, $this->user, $this->pass);
                $this->connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $this->connect;
            }
            catch(PDOException $e){
                echo "Connection failed: " . $e->getMessage();
                return $this->connect = NULL;
            }
            
        }

        public function lastInsertId(){
            return $this->connect->lastInsertId();
        }
    }

?>