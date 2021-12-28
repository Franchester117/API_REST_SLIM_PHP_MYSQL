<?php
    class Conexion{
        private $dbname = "clientes_db";
        private $host = "localhost";
        private $user = "root";
        private $password = "";

        public function connection() {
            $mysqlConnect = "mysql:host=$this->host;
                             dbname=$this->dbname";
            $dbConnection = new PDO(
                    $mysqlConnect,
                    $this->user,
                    $this->password
            );
            $dbConnection->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );
            
            return $dbConnection;
        }
    }
?>