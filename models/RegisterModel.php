<?php

require_once "Database.php";

class RegisterModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function addUser($username, $email, $password)
    {
        $this->db->query("INSERT INTO users(username, email, password) VALUES (:username, :email, :password)");
        
        $this->db->bind(":username", $username);
        $this->db->bind(":email", $email);
        $this->db->bind(":password", $password);

        return $this->db->execute();
    }
}