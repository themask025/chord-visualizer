<!DOCTYPE html>
<html lang="en">

<head>
  <?php require_once(__DIR__ . "/../navigation_bar/index.php");
  require_once(__DIR__ . "/../../constants.php");
  ?>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://unpkg.com/tone"></script>
  <title>Tab editor</title>
  <link rel="stylesheet" href=<?php echo '"' . BASE_PATH . '/views/tab_editor/tab_editor.css"' ?> />


<body>
  <?php

  if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }
  if (!isset($data)) {
    exit;
  }
  echo '<p id="json-data">' . json_encode($data) . '</p>';
  $action = BASE_PATH . "version/updateTab";
  $submit_name = "Update tab";
  $class_name = "";
  $logged_in = isset($_SESSION["user_id"]);
  if ($data["page_type"] === "song_creation") {
    $action = BASE_PATH . "version/createTab";
    $submit_name = "Create tab";
  }

  if ($data["can_edit"] === false) {
    $class_name = "display-none";
  }

  $song_name = $data["song_name"];
  $song_author = $data["song_author"];
  $version_creator = $data["version_creator"];
  $version_id = $data["version_id"];

  echo "<div class=\"song-info\">";
  echo "<h2 class=\"song-name\">Song name: {$song_name}</h2>";
  echo "<h2 class=\"song-author\">Song author: {$song_author}</h2>";
  if ($data["page_type"] === "song_view") {
    echo "<h3 class=\"tabs-creator\">Tabs created by <em>{$version_creator}</em></h3>";
  }
  echo "</div>";
  ?>
  <div id="tabs-container"></div>
  <div id="comments-section">
    <p><strong>Comments:</strong></p>
    <?php
    if ($logged_in && $data["page_type"] === "song_view") {
      echo '<form id="comment-form" method="POST" action= ' . BASE_PATH . 'comment/addComment>';
      echo "<input type=\"text\" id=\"comment-text\" placeholder=\"Comment on this song\" name=\"comment_text\" />";
      echo "<input class=\"display-none\" type=\"text\" id=\"comment-version-id\" name=\"version_id\" value=\"{$version_id}\" />";
      echo '<input type="submit" hidden />';
      echo '</form>';
    }

    foreach ($data["comments"] as $comment) {
      echo "<div class=\"comment\">";
      echo "<div class=\"comment-author\">{$comment["username"]}</div>";
      echo "<div class=\"comment-timestamp\">{$comment["upload_timestamp"]}</div>";
      echo '<form class="update-comment-form" method="POST" action= "' . BASE_PATH . 'comment/updateComment\">';
      echo "<input class=\"comment-text\" type=\"text\" id=\"comment-text-" . $comment["id"] . "\" placeholder=\"Update your comment\" name=\"comment_text\"" . (!isset($_SESSION["user_id"]) || $comment["author_id"] != $_SESSION["user_id"] ? " disabled" : "") . " value=\"{$comment["content"]}\" />";
      echo "<input class=\"display-none\" type=\"text\" id=\"comment-id-" . $comment["id"] . "\" name=\"comment_id\" value=\"{$comment["id"]}\" />";
      echo "<input class=\"display-none\" type=\"text\" id=\"comment-version-id-" . $comment["id"] . "\" name=\"version_id\" value=\"{$version_id}\" />";
      echo '<input type="submit" hidden />';
      echo "</form>";
      echo "</div>";
    }

    if (count($data["comments"]) == 0) {
      echo "<p>No comments here</p>";
    }
    ?>
  </div>
  <div id="tab-styler">
    <strong>Tab styler:</strong>
    <br>
    <input type="text" id="fretting-control-styler" placeholder="Fret number circle style">
    <button onclick="set_fretting_control_styles_from_input()" id="fretting-control-style-button">Update styles</button>
    <br>
    Set border radius:
    <input id="border-radius-slider" type="range" min="0" max="50" value="50" onchange="set_border_radius(event)" />
    <br>
    String:
    <select id="string-pick">
      <option value="e">e</option>
      <option value="B">B</option>
      <option value="G">G</option>
      <option value="D">D</option>
      <option value="A">A</option>
      <option value="E">E</option>
    </select>
    Color:
    <button id="yellow-string-color" onclick="set_string_color('yellow')">&nbsp;</button>
    <button id="blue-string-color" onclick="set_string_color('blue')">&nbsp;</button>
    <button id="red-string-color" onclick="set_string_color('red')">&nbsp;</button>
    <br>
    Fret number circle border color:
    <button id="yellow-border-color" onclick="set_border_color('yellow')">&nbsp;</button>
    <button id="blue-border-color" onclick="set_border_color('blue')">&nbsp;</button>
    <button id="red-border-color" onclick="set_border_color('red')">&nbsp;</button>
    <br>
    <button id="dalmatian-theme" onclick="set_random_dalmatian_theme()">Random dalmatian theme</button>
    <br>
    <input type="file" accept="image/png, image/jpeg" id="background-uploader" onchange="update_background()" />
  </div>
  <div id="tab-related-buttons-footer">
    <div class="bpm-container">
      <p>BPM: <output id="bpm-value"></output></p>
      <?php
      echo "<input class=\"{$class_name}\" type=\"range\" min=\"1\" max=\"300\" id=\"bpm-slider\" />";
      ?>
    </div>
    <?php
    echo "<button class=\"{$class_name}\" id=\"add-bar-button\">Add bar</button>";
    ?>
    <button id="play-tabs-button">Play tabs</button>
    <?php
    echo "<label class=\"{$class_name}\" for=\"tabs-uploader\" id=\"tabs-uploader-label\" />Load a JSON song file</label>";
    echo "<input class=\"{$class_name}\" type=\"file\" accept=\".json\" id=\"tabs-uploader\" />";
    ?>
    <button id="tabs-downloader">Download current tab data</button>
    <?php
    echo "<form class=\"{$class_name}\" id=\"tab-form\" method=\"POST\" action=\"{$action}\">";
    echo "<input class=\"display-none\" type=\"text\" id=\"version-id\" name=\"version_id\" />";
    ?>
    <input class="display-none" type="text" id="version-data" name="version_data" />
    <input class="display-none" type="text" id="song-name" name="song_name" />
    <input class="display-none" type="text" id="song-author" name="song_author" />
    <?php
    echo "<input id=\"tabs-submit\" type=\"submit\" value=\"{$submit_name}\"/>";
    echo "</form>";
    ?>
  </div>
  <script src=<?php echo '"' . BASE_PATH . '/views/tab_editor/tab_editor.js"' ?>>
  </script>
</body>

</html>