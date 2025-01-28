<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Landing page</title>
</head>

<body>
    <style>
        .song-form-blur {
            z-index: 3;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%; 
            backdrop-filter: blur(10px);
        }
        .song-form-background {
            z-index: 4;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%; 
            background: black;
            opacity: 0.8;
        }

        .song-form {
            z-index: 5;
            position: relative;
            top: 50%;
            left: 50%;
            -ms-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
            width: 300px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2em;
            background-color: #121212;
            opacity: 1;
            border-radius: 1em;
        }

        .song-form input[type="text"] {
            padding: 1em;
            margin: 2em 1.4em 1.2em 1.4em;
            width: 75%;
            border-radius: 1em;
        }

        .submit-button {
            margin: 1em;
            width: fit-content;
        }

        .close-button {
            position: absolute;
            top: 1em;
            right: 1em; 
            background: none;
            color: white;
            border: none;
            font-size: 1.2rem;
        }

        a {
            cursor: pointer;
        }
    </style>
    <script>
        const set_form_hidden = (hidden) => {
            const form = document.getElementsByClassName("song-form")[0];
            const form_background = document.getElementsByClassName("song-form-background")[0];
            const form_blur = document.getElementsByClassName("song-form-blur")[0];
            form.hidden = hidden;
            form_background.hidden = hidden;
            form_blur.hidden = hidden;
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
        echo 'or <a onclick="set_form_hidden(false)"><u>create a new song</u></a>';
        echo '<div class="song-form-blur" hidden>';
        echo '<div class="song-form-background" hidden>';
        echo '<form class="song-form" action="/chord-visualizer/version/initTab" method="post" hidden>';
        echo '<button class="close-button" onclick="set_form_hidden(true)">X</button>';
        echo '<input class="form-input" type="text" placeholder="Enter song name" id="song_name" name="song_name" required>';
        echo '<input class="form-input" type="text" placeholder="Enter song author" id="song_author" name="song_author" required>';
        echo '<button class="submit-button" type="submit">Add song</button>';
        echo '</form>';
        echo '</div>';
        echo '</div>';
    }
    ?>
</body>

</html>
