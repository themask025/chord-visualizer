<?php

require_once 'controller.php';
class VersionController extends Controller
{
    private $version_model;
    private $song_model;
    private $default_version;
    private $comments_model;


    public function __construct()
    {
        $this->version_model = $this->loadModel('Version');
        $this->song_model = $this->loadModel('Song');
        $this->comments_model = $this->loadModel('Comments');
        $this->default_version =
            ["content" => file_get_contents(__DIR__ . "/../example-songs/fly_me_to_the_moon.json"),
             "version_name" => "Default",
             "song_id" => 0,
             "creator_id" => 0];
    }

    private function songExist($song_id)
    {
        return $this->song_model->getSongById($song_id) != null;
    }

    public function updateTab()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $this->version_model->updateVersion($_POST["version_id"], $_POST["version_name"], $_POST["content"]);
            $this->index();
        }
    }

    public function tabEditor()
    {
        if($_SERVER['REQUEST_METHOD'] === 'GET')
        {
            $version = isset($_GET["version_id"]) ?
                       $this->version_model->getVersionById($_GET["version_id"]) :
                       $this->default_version;
            if($version == null)
            {
                $version = $this->default_version;
            }

            $data = ["version" => $version];
            $this->renderView('tab_editor', $data);
        }
        else if($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $song_id = 0;
            if(isset($_POST["song_id"]))
            {
                $song_id = $_POST["song_id"];
            }
            else
            {
                $this->song_model->createSong($_POST["song_name"],$_POST["performer"]);
                $song_id = $this->song_model->getSongByNamePerformer($_POST["song_name"],$_POST["performer"])["id"];

            }
            $this->version_model->createVersion($_POST["user_id"],$song_id,$_POST["version_name"],$_POST["content"]);
           $this->index();
        }

    }
    public function searchSongVersions()
    {
        if($_SERVER['REQUEST_METHOD'] === 'GET')
        {
            $song_id = $_GET["song_id"];
            $versions = $this->version_model->getVersionsNameAuthorBySongId($song_id);
            foreach ($versions as $key => $version)
            {
                $versions[$key]["comments_count"] = count($this->comments_model->getComments($version["id"]));
            }
            $data  = ["versions" => $versions];
            $this->renderView('song_versions', $data);
        }

    }
    public function index()
    {
        require_once __DIR__ . '/../views/tab_editor/tab_editor.php';
        // require_once __DIR__ . '/../views/version/version.php';
        // TODO: add upper line when version page is ready
    }
}
