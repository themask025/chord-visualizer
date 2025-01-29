<!DOCTYPE html>
<html lang="en">

<?php
require_once(__DIR__ . "/../../constants.php");
?>

<head>
    <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>
    <link rel="stylesheet" href="<?php echo BASE_PATH; ?>views/home/styles.css">
    <meta charset="UTF-8">
    <title>Landing page</title>
</head>

<body>
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
    ?>

    <div class="main-container">
        <?php
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        ?>
        <div class="landing-page-title-container">
            <h1 class="landing-page-title">Welcome to </h1>
            <h1>CHORD VISUALIZER</h1>
            <img src="<?php echo BASE_PATH; ?>assets/landing_page_title_notes.png" class="landing-page-title-image" alt="Notes">
        </div>

        <form class="song-search" action="/chord-visualizer/song/findSong" method="GET">
            <input type="text" name="song_name" placeholder="Search for a song by its name">
            <input type="submit" hidden>
        </form>

        <?php
        if (isset($_SESSION["user_id"])) {
            echo '<p class="song-creation-label"> or <a onclick="set_form_hidden(false)"><u class="song-creation-link">add tabs for a song</u></a> </p>';
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
    </div>
</body>

</html>