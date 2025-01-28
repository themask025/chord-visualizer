<?php

require_once 'model.php';
class Version extends Model
{

    public function createVersion($user_id,$song_id, $version_name, $content)
    {
        $this->db->query( "INSERT INTO versions (creator_id, song_id, name, content) VALUES (:user_id, :song_id, :version_name, :content)");

        $this->db->bind(":user_id", $user_id);
        $this->db->bind(":song_id", $song_id);
        $this->db->bind(":version_name", $version_name);
        $this->db->bind(":content", $content);
        $this->db->execute();
    }
    public function getVersionById($version_id)
    {
        $this->db->query("SELECT * FROM versions WHERE id = :version_id");
        $this->db->bind(":version_id", $version_id);
        return $this->db->fetchSingleResult();
    }
    public function getVersionsNameAuthorBySongId($song_id,$limit = '10',$offset = '0')
    {
        $this->db->query("SELECT versions.id, versions.name, users.username as 'version_author' FROM versions" .
                            " JOIN users ON versions.creator_id = users.id WHERE song_id = :song_id LIMIT "
                            . intval($limit)." OFFSET ".intval($offset));
        $this->db->bind(":song_id", $song_id);
        return $this->db->fetchAllResults();
    }

    public function getVersionsByUserId($user_id,$limit = 10,$offset = 0)
    {
        $this->db->query("SELECT * FROM versions WHERE creator_id = :user_id LIMIT " . intval($limit)." OFFSET ".intval($offset));
        $this->db->bind(":user_id", $user_id);
        $this->db->bind(":limit", $limit);
        $this->db->bind(":offset", $offset);
        return $this->db->fetchAllResults();
    }

    public function updateVersion($version_id,$version_name ,$content)
    {
        $this->db->query("UPDATE versions SET content = :content, name = :version_name WHERE id = :version_id");
        $this->db->bind(":content", $content);
        $this->db->bind(":version_name", $version_name);
        $this->db->bind(":version_id", $version_id);
        $this->db->execute();
    }

    public function deleteVersion($version_id)
    {
        $this->db->query("DELETE FROM versions WHERE id = :version_id");
        $this->db->bind(":version_id", $version_id);
        $this->db->execute();
    }

}