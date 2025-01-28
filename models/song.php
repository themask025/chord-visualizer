<?php

class Song extends Model
{
    public function getSongById($songId)
    {
        $this->db->query("SELECT * FROM songs WHERE id = :song_id");
        $this->db->bind(":song_id", $songId);
        return $this->db->fetchSingleResult();
    }
    public function getSongByNamePerformer($song_name, $performer)
    {
        $this->db->query("SELECT * FROM songs WHERE title = :song_name AND performer = :performer");
        $this->db->bind(":song_name", $song_name);
        $this->db->bind(":performer", $performer);
        return $this->db->fetchSingleResult();
    }
    public function createSong($song_name, $performer)
    {
        $this->db->query("INSERT INTO songs (title, performer) VALUES (:song_name, :performer)");
        $this->db->bind(":song_name", $song_name);
        $this->db->bind(":performer", $performer);
        $this->db->execute();
    }

    public  function filterSongsByName($song_name, $limit)
    {
        $this->db->query("SELECT * FROM songs WHERE title LIKE :song_name LIMIT :limit");
        $searchPattern = "%" . $song_name . "%";
        $this->db->bind(":song_name", $searchPattern);
        $this->db->bind(":limit", $limit);
        return $this->db->fetchAllResults();
    }
    
    public function getVersionCountOfSong($song_id)
    {
        $this->db->query("SELECT COUNT(*) as 'count' FROM versions WHERE id = :song_id");
        $this->db->bind(":song_id", $song_id);
        $this->db->execute();
        return $this->db->fetchSingleResult();
        
    }

}
