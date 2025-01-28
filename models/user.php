<?php

require_once("model.php");

class User extends Model
{
    public function getUserFromUsername($username)
    {
        $this->db->query("SELECT * FROM users WHERE username=:username");
        
        $this->db->bind(":username", $username);

        return $this->db->fetchSingleResult();
    }

    public function getUserFromId($id)
    {
        $this->db->query("SELECT username FROM users WHERE id=:id");
        
        $this->db->bind(":id", $id);

        return $this->db->fetchSingleResult();
    }

    public function getUsernameFromId($id)
    {
        $user = $this->getUserFromId($id);
        return $user["username"];
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