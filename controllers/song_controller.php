<?php

require_once (__DIR__ . '/../constants.php');
require_once (__DIR__ . '/controller.php');
class SongController extends Controller
{
    private $song_model;
    private $version_model;

    public function __construct()
    {
        $this->song_model = $this->loadModel('Song');
        $this->version_model = $this->loadModel('Version');
    }

    public function findSong()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET')
        {
            $songs = $this->song_model->filterSongsByName($_GET["song_name"]);
            $search_results = [];

            foreach ($songs as $key => $song)
            {
                $version_count = count($this->version_model->getVersionsNameAuthorBySongId($song["id"]));
                if ($version_count === 1) {
                  $version_count = "1 version"; 
                } else {
                  $version_count = "{$version_count} versions";
                }
                $search_results[$key]["href"] = BASE_PATH."version/searchSongVersions?song_id={$song["id"]}";
                $search_results[$key]["main"] = $song["title"];
                $search_results[$key]["sub"] = $song["performer"];
                $search_results[$key]["count"] = $version_count;
            }
            $data  = ["search_query" => 'Search results for "'.$_GET["song_name"].'"', "search_results" => $search_results];
            $this->renderView('search_results', $data);
        }
    }
    public function index()
    {
      header("Location: ". BASE_PATH);
    }

}
