<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add song</title>
</head>

<body>
    <form class="song-form" action="/chord-visualizer/version/initTab" method="post">
        <input class="form-input" type="text" id="song_name" name="song_name" required>
        <input class="form-input" type="text" id="song_author" name="song_author" required>
        <button class="submit-button" type="submit">Add song</button>
    </form>
</body>

</html>