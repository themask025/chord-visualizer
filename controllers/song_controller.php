<?php

require_once "controller.php";
class SongController extends Controller
{
    private $song_model;

    public function __construct()
    {
        $this->song_model = $this->loadModel('Song');
    }

    public function findSong()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET')
        {
            $songs = $this->song_model->filterSongsByName($_GET["song_name"]);
            $data = ["songs" => $songs];
        }
        $this->renderView('found_songs', $data);
    }
    public function index()
    {
        $this->renderView('songs');
    }

}