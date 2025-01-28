<?php

require_once 'controller.php';
class VersionController extends Controller
{
  private $version_model;
  private $song_model;
  private $default_version;
  private $comment_model;
  private $user_model;


  public function __construct()
  {
    $this->version_model = $this->loadModel('Version');
    $this->song_model = $this->loadModel('Song');
    $this->comment_model = $this->loadModel('Comment');
    $this->user_model = $this->loadModel('User');
  }

  private function songExist($song_id)
  {
    return $this->song_model->getSongById($song_id) != null;
  }

  public function updateTab()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST')
    {
      $this->version_model->updateVersion($_POST["version_id"], "TAB", $_POST["version_data"]);
      header("Location: /chord-visualizer/version/tabEditor?version_id={$_POST["version_id"]}");
    }
  }

  public function initTab()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST')
    {
      session_start();
      if (!isset($_SESSION["user_id"])) {
        header("Location: /chord-visualizer/");
        exit;
      }

      if (isset($_POST["song_name"]) && isset($_POST["song_author"])) {
        $data = [
          "page_type" => "song_creation",
          "can_edit" => true,
          "song_name" => $_POST["song_name"],
          "song_author" => $_POST["song_author"],
          "version_creator" => $_SESSION["user_id"],
          "comments" => []
        ];
        $this->renderView('tab_editor', $data);
      }
    }
  }

  public function createTab()
  {
    if($_SERVER['REQUEST_METHOD'] === 'POST')
    {
      session_start();
      if (!isset($_SESSION["user_id"])) {
        header("Location: /chord-visualizer/");
        exit;
      }
      $song = $this->song_model->getSongByNamePerformer($_POST["song_name"],$_POST["song_author"]);

      if ($song == null) {
        $this->song_model->createSong($_POST["song_name"],$_POST["song_author"]);
        $song = $this->song_model->getSongByNamePerformer($_POST["song_name"],$_POST["song_author"]);
      }

      $this->version_model->createVersion($_SESSION["user_id"],$song["id"],"TAB",$_POST["version_data"]);
      header("Location: /chord-visualizer/version/searchSongVersions?song_id={$song["id"]}");
    }
  }

  public function tabEditor()
  {
    session_start();
    if($_SERVER['REQUEST_METHOD'] === 'GET')
    {
      if (!isset($_GET["version_id"])) {
        header("Location: /chord-visualizer/");
        exit;
      }

      $version = $this->version_model->getVersionById($_GET["version_id"]);
      if($version == null)
      {
        header("Location: /chord-visualizer/");
        exit;
      }

      $song = $this->song_model->getSongById($version["song_id"]);

      $can_edit = false;
      $page_type = "song_view";
      if (isset($_SESSION["user_id"]) && $_SESSION["user_id"] === $version["creator_id"]) {
        $can_edit = true;
      }
      $comments = $this->comment_model->getComments($version["id"]);
      foreach ($comments as $key => $comment) {
        $comments[$key]["username"] = $this->user_model->getUsernameFromId($comment["author_id"]);
      }

      $username = $this->user_model->getUsernameFromId($version["creator_id"]);

      $data = [
        "version_creator" => $username,
        "page_type" => $page_type,
        "version_id" => $version["id"],
        "version_data" => json_decode($version["content"]),
        "can_edit" => $can_edit,
        "song_name" => $song["title"],
        "song_author" => $song["performer"],
        "comments" => $comments
      ];
      $this->renderView('tab_editor', $data);
    }

  }
  public function searchSongVersions()
  {
    if($_SERVER['REQUEST_METHOD'] === 'GET')
    {
      $song_id = $_GET["song_id"];
      $versions = $this->version_model->getVersionsNameAuthorBySongId($song_id);
      $song = $this->song_model->getSongById($song_id);
      $search_results = [];

      foreach ($versions as $key => $version)
      {
        $versions[$key]["comments_count"] = count($this->comment_model->getComments($version["id"]));
        $search_results[$key]["href"] = "/chord-visualizer/version/tabEditor?version_id={$version["id"]}";
        $search_results[$key]["main"] = "Version {$key}";
        $search_results[$key]["sub"] = $versions[$key]["version_author"];
        $search_results[$key]["count"] = "{$versions[$key]["comments_count"]} comments";
      }
      $data  = ["search_query" => 'All versions of "'.$song["title"].'" by "'.$song["performer"].'"', "search_results" => $search_results];
      $this->renderView('search_results', $data);
    }

  }
  public function index()
  {
    require_once __DIR__ . '/../views/tab_editor/tab_editor.php';
    // require_once __DIR__ . '/../views/version/version.php';
    // TODO: add upper line when version page is ready
  }
}
