<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://unpkg.com/tone"></script>
    <title>Tab editor</title>
      <link rel="stylesheet" href="/chord-visualizer/views/tab_editor/tab_editor.css" />
  </head>
  <body>
<?php
require_once(__DIR__."/../navigation_bar/index.php");

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
if (isset($data)) {
  echo '<p id="json-data">'.json_encode($data).'</p>';
}
$action = "/chord-visualizer/version/updateTab";
$submit_name = "Update tab";
$class_name = "";
if ($data["page_type"] === "song_creation") {
  $action = "/chord-visualizer/version/createTab";
  $submit_name = "Create tab";
}

if ($data["can_edit"] === false) {
  $class_name = "display-none";
}

$song_name = $data["song_name"];
$song_author = $data["song_author"];
$version_creator = $data["version_creator"];

echo "<h2>\"{$song_name}\" by \"{$song_author}\"</h2>";
if ($data["page_type"] === "song_view") {
    echo "<h3>Tabs created by user <em>{$version_creator}</em></h3>";
}
?>
    <div class="bpm-container">
      <p>BPM: <output id="bpm-value"></output></p>
<?php
echo "<input class=\"{$class_name}\" type=\"range\" min=\"1\" max=\"300\" id=\"bpm-slider\" />";
?>
    </div>
    <div id="tabs-container"></div>
<?php
echo "<button class=\"{$class_name}\" id=\"add-bar-button\">Add bar</button>";
?>
    <button id="play-tabs-button">Play tabs</button>
<?php
    echo "<input class=\"{$class_name}\"type=\"file\" accept=\".json\" id=\"tabs-uploader\" />";
?>
    <button id="tabs-downloader">Download current tab data</button>
<?php
echo "<form class=\"{$class_name}\" id=\"tab-form\" method=\"POST\" action=\"{$action}\">";
?>
      <input class="display-none" type="text" id="version-id" name="version_id" />
      <input class="display-none" type="text" id="version-data" name="version_data" />
      <input class="display-none" type="text" id="song-name" name="song_name" />
      <input class="display-none" type="text" id="song-author" name="song_author" />
<?php
echo "<input type=\"submit\" value=\"{$submit_name}\"/>"
?>
    </form>
    <script src="/chord-visualizer/views/tab_editor/tab_editor.js"></script>
  </body>
</html>
