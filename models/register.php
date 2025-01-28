<?php

require_once "database.php";

class Register
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

    public function checkUsernameExists($username)
    {
        $this->db->query("SELECT * FROM users WHERE username=:username;");
        $this->db->bind(":username", $username);
        $result = $this->db->fetchSingleResult();
        return (empty($result) == false);
    }

    public function checkEmailExists($email)
    {
        $this->db->query("SELECT * FROM users WHERE email=:email;");
        $this->db->bind(":email", $email);
        $result = $this->db->fetchSingleResult();
        return (empty($result) == false);
    }

}