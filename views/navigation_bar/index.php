<!DOCTYPE html>
<html lang="en">

<head>
    <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>
    <link rel="stylesheet" href="styles.css">
</head>

<body>

    <nav class="navbar">
        <a href="/chord-visualizer/login" class="logo">CHORD VISUALIZER</a>

        <?php
        session_start();
        if (isset($_SESSION["user_id"])) {
        ?>
            <form method="post" class="logout_form">
                <label for="logout_button"><?php echo $_SESSION["username"]; ?></label>
                <button type="submit" id="logout_button">Log out</button>
            </form>
        <?php
        } else {
            echo "<a href=\"/chord-visualizer/login\" class=\"login_button\", type>Log in</a>";
        }
        ?>
    </nav>


</body>