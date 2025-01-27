<?php

require "models/database.php";

class Comments
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function storeComment($song_version_id, $author_name, $timestamp, $content)
    {
        $sql = "INSERT INTO comments(song_version_id, author, upload_timestamp, content) VALUES (:song_version_id, :author, :upload_timestamp, :content)";
        $this->db->query($sql);

        $this->db->bind(":song_version_id", $song_version_id);
        $this->db->bind(":author", $author_name);
        $this->db->bind(":upload_timestamp", $timestamp);
        $this->db->bind(":content", $content);

        return $this->db->execute();
    }

    public function retrieveComment($song_version_id)
    {
        $sql = "SELECT author, upload_timestamp, content FROM comments WHERE song_version_id=:song_version_id";
        $this->db->query($sql);

        $this->db->bind(":song_version_id", $song_version_id);

        $result = $this->db->getAllResults();
        return $result;
    }
}