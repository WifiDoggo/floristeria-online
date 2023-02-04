<?php
    class dataBase 
    {
        private $hostname = "localhost";
        private $database = "registro";
        private $username = "root";
        private $password = "";
        private $charset = "utf8";

        function conectar()
        {
            $conexion = "mysql:host=".$this->hostname."; dbname=".$this->database."; charset=".$this->charset;
            $opciones = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, //genera excepciones
                PDO::ATTR_EMULATE_PREPARES => false          //asegura que las consultas sean reales y seguras
            ];

            $pdo = new PDO($conexion, $this->username, $this->password, $opciones);

            return $pdo;
        } function catch(PDOException $e){
            echo 'Error de conexión: '.$e->getMessage();
            exit;
        }
    }
?>