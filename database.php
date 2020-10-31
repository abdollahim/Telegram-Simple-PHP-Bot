<?php

class DB
{
    private $serverName = "localhost";
    private $username = "";
    private $password = "";
    private $databaseName = "";

    private $connection = null;

    function __construct()
    {
        try {
            $this->connection = new PDO("mysql:host=" . $this->serverName . ";dbname=" . $this->databaseName, 
            $this->username, $this->password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    // log functions
    function getLogs()
    {
        try {
            // set the PDO error mode to exception
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $db_select = $this->connection->prepare("SELECT * FROM `logs` ORDER BY id DESC");

            // use execute() because results will be returned
            $db_select->execute();
            return $db_select->fetchAll();
        } catch (PDOException $e) {
            $this->addLog($e->getMessage());
            return false;
        }
    }

    function getLog($log_type, $guid)
    {
        try {
            // set the PDO error mode to exception
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $db_select = $this->connection->prepare("SELECT * FROM `logs` WHERE `log_type`='" . $log_type . "' AND `id`='" . $guid . "' LIMIT 1");

            // use execute() because results will be returned
            $db_select->execute();
            return $db_select->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->addLog($e->getMessage());
            return false;
        }
    }

    function addLog($message)
    {
        try {
            // set the PDO error mode to exception
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO `logs` (`message`) VALUES ('" . $message . "')";

            // use exec() because no results are returned
            $this->connection->exec($sql);
            return true;
        } catch (PDOException $e) {
            return $e->getMessage();
            return false;
        }
    }
}
