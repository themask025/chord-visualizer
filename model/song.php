<?php

namespace model;

class Song extends Model
{
    public function __construct($db)
    {
        parent::__construct($db);
    }
    public function create_song($song_name, $performer)
    {
        $sql = "INSERT INTO songs (song_name, performer ) VALUES (:song_name, :performer)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":song_name", $song_name);
        $stmt->bindValue(":performer", $performer);
        $stmt->execute();
    }

    public  function filter_songs_by_name($song_name, $limit)
    {
        $sql = "SELECT * FROM songs WHERE song_name LIKE :song_name LIMIT :limit";
        $stmt = $this->db->prepare($sql);
        $searchPattern = "%" . $song_name . "%";
        $stmt->bindValue(":song_name", $searchPattern);
        $stmt->bindValue(":limit", $limit);
        $stmt->execute();
        return $stmt->fetch();
    }
    
    public function get_version_count_of_song($song_id)
    {
        $sql = "SELECT COUNT(*) FROM versions WHERE song_id = :song_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":song_id", $song_id);
        $stmt->execute();
        return $stmt->fetch();
        
    }

}