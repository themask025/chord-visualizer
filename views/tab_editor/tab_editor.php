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
session_start();
if (isset($_SESSION["user_id"])) {
  echo "COOL";
}
if (isset($data)) {
  echo '<p id="json-data">'.json_encode($data).'</p>';
}
?>
    <div class="bpm-container">
      <p>BPM: <output id="bpm-value"></output></p>
      <input type="range" min="1" max="300" id="bpm-slider" />
    </div>
    <div id="tabs-container"></div>
    <button id="add-bar-button">Add bar</button>
    <button id="play-tabs-button">Play tabs</button>
    <input type="file" accept=".json" id="tabs-uploader" />
    <button id="tabs-downloader">Download current tab data</button>
    <form id="tab-form" method="POST">
      <input class="display-none" type="text" id="song-id" name="song_id" />
      <input class="display-none" type="text" id="user-id" name="user_id" />
      <input class="display-none" type="text" id="version-name" name="version_name" />
      <input class="display-none" type="text" id="song-title" name="song_title" />
      <input class="display-none" type="text" id="performer" name="performer" />
      <input class="display-none" type="text" id="content" name="content" />
      <input type="submit" />
    </form>
    <script src="/chord-visualizer/views/tab_editor/tab_editor.js"></script>
  </body>
</html>
