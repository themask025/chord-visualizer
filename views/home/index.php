<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Landing page</title>
</head>

<body>
    <script>
        const set_form_hidden = (hidden) => {
            const form = document.getElementsByClassName("song-form")[0];
            form.hidden = hidden;
        }
    </script>
    <?php
    require_once(__DIR__ . "/../navigation_bar/index.php");

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    echo '<form class="song-search" action="/chord-visualizer/song/findSong" method="GET">';
    echo '<input type="text" name="song_name" placeholder="Search for a song by its name">';
    echo '<input type="submit" hidden>';
    echo '</form>';

    if (isset($_SESSION["user_id"])) {
        echo 'or <a href="#" onclick="set_form_hidden(false)"><u>create a new song</u></a>';
        echo '<form class="song-form" action="/chord-visualizer/version/initTab" method="post" hidden>';
        echo '<button onclick="set_form_hidden(true)">X</button>';
        echo '<input class="form-input" type="text" id="song_name" name="song_name" required>';
        echo '<input class="form-input" type="text" id="song_author" name="song_author" required>';
        echo '<button class="submit-button" type="submit">Add song</button>';
        echo '</form>';
    }
    ?>
</body>

</html>