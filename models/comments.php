<?php

require "models/database.php";

class Comments
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    function validateDate($date, $format = 'Y-m-d H:i:s') { 
        $d = DateTime::createFromFormat($format, $date); 
        return $d && $d->format($format) === $date; 
    } 

    public function storeComment($song_version_id, $author_name, $timestamp, $content)
    {
        if($this->validateDate($timestamp) == false)
        {
            throw new Exception("Invalid timestamp format passed for storing in the database!");
        }

        $sql = "INSERT INTO comments(song_version_id, author, upload_timestamp, content) VALUES (:song_version_id, :author, :upload_timestamp, :content)";
        $this->db->query($sql);

        $this->db->bind(":song_version_id", $song_version_id);
        $this->db->bind(":author", $author_name);
        $this->db->bind(":upload_timestamp", $timestamp);
        $this->db->bind(":content", $content);

        return $this->db->execute();
    }

    public function getComments($song_version_id)
    {
        $sql = "SELECT author, upload_timestamp, content FROM comments WHERE song_version_id=:song_version_id";
        $this->db->query($sql);

        $this->db->bind(":song_version_id", $song_version_id);

        $result = $this->db->fetchAllResults();
        return $result;
    }
}