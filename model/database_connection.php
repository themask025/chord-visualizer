<?php

namespace model;

use PDO;
use PDOException;

class Database_connection
{
    private $connection;

    public function __construct()
    {
        require_once  'constants.php';
        try {
            $this->connection = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER_NAME, DB_USER_PASSWORD);
        }
        catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();  // TODO: Change echo to writing into log file
        }
    }

    public function getConnection()
    {
        return $this->connection;
    }
}