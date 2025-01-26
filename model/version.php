<?php

namespace model;

class Version extends Model
{
    public function __construct($db)
    {
        parent::__construct($db);
    }

    public function create_version($user_id,$song_id, $version_name, $content)
    {
        $sql = "INSERT INTO versions (creator_id, song_id, name, content) VALUES (:user_id, :song_id, :version_name, :content)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":user_id", $user_id);
        $stmt->bindValue(":song_id", $song_id);
        $stmt->bindValue(":version_name", $version_name);
        $stmt->bindValue(":content", $content);
        $stmt->execute();
    }
    public function get_version_by_id($version_id)
    {
        $sql = "SELECT * FROM versions WHERE id = :version_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":version_id", $version_id);
        $stmt->execute();
        return $stmt->fetch();
    }
    public function get_versions_by_song_id($song_id,$limit = 10,$offset = 0)
    {
        $sql = "SELECT * FROM versions WHERE song_id = :song_id LIMIT :limit OFFSET :offset";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":song_id", $song_id);
        $stmt->bindValue(":limit", $limit);
        $stmt->bindValue(":offset", $offset);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function get_versions_by_user_id($user_id,$limit = 10,$offset = 0)
    {
        $sql = "SELECT * FROM versions WHERE creator_id = :user_id LIMIT :limit OFFSET :offset";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":user_id", $user_id);
        $stmt->bindValue(":limit", $limit);
        $stmt->bindValue(":offset", $offset);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function update_version($version_id, $content)
    {
        $sql = "UPDATE versions SET content = :content WHERE id = :version_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":content", $content);
        $stmt->bindValue(":version_id", $version_id);
        $stmt->execute();
    }

    public function delete_version($version_id)
    {
        $sql = "DELETE FROM versions WHERE id = :version_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":version_id", $version_id);
        $stmt->execute();
    }

}