<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://unpkg.com/tone"></script>
    <title>Tab editor</title>
        <link rel="stylesheet" href="tab_editor.css" />
      <link rel="stylesheet" href="/chord-visualizer/views/tab_editor/tab_editor.css" />
      <?php
      if (isset($data)) {
          echo json_encode($data);
      } else {
          echo "Version name not available";
      }
      ?>
  </head>
  <body>
    <div class="bpm-container">
      <p>BPM: <output id="bpm-value"></output></p>
      <input type="range" min="1" max="300" id="bpm-slider" />
    </div>
    <div id="tabs-container"></div>
    <button id="add-bar-button">Add bar</button>
    <button id="play-tabs-button">Play tabs</button>
    <input type="file" accept=".json" id="tabs-uploader" />
    <button id="tabs-downloader">Download current tab data</button>
    <script src="./tab_editor.js"></script>
    <script src="/chord-visualizer/views/tab_editor/tab_editor.js"></script>
  </body>
</html>
