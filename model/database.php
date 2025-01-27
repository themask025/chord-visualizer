<?php

require_once "constants.php";

class Database
{
    private $host = DB_HOST;
    private $user = DB_USER;
    private $password = DB_PASS;
    private $dbname = DB_NAME;
    private $dbport = DB_PORT;

    private $dbh; //Database handler
    private $stmt;
    private $error;

    public function __construct()
    {
        // Data Source Name (DSN) for the PDO connection
        $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->dbname . ";port=" . $this->dbport;

        $options = [
            // Use persistent connection
            // Prevents establishing a new connection each time when an instance of Database (object) is created.
            PDO::ATTR_PERSISTENT => true,

            // Throw exceptions on errors
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];

        try
        {
            $this->dbh = new PDO($dsn, $this->user, $this->password, $options);
        }
        catch (PDOException $e)
        {
            $this->error = $e->getMessage();
            echo $this->error;
        }
    }

    public function query($sql)
    {
        $this->stmt = $this->dbh->prepare($sql);
    }

    public function execute()
    {
        return $this->stmt->execute();
    }

    public function fetchSingleResult()
    {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function fetchAllResults()
    {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function bind($param, $value)
    {
        $this->stmt->bindValue($param, $value);
    }
}