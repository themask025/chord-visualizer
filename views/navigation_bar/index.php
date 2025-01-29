<!DOCTYPE html>
<html lang="en">

<?php
require_once(__DIR__ . "/../../constants.php");
?>

<head>
    <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>
    <link rel="stylesheet" href="<?php echo BASE_PATH; ?>views/navigation_bar/styles.css">
</head>

<body>

    <nav class="navbar">
        <a href="/chord-visualizer/" class="navbar logo">CHORD VISUALIZER</a>

        <?php
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION["user_id"])) {
        ?>
            <form action="<?php echo BASE_PATH; ?>login/logout" method="post" class="navbar logout_form">
                <input type="text" name="sender" value="<?php echo $_SERVER['REQUEST_URI']; ?>" hidden>
                <label for="navbar logout_button" class="username"><?php echo $_SESSION["username"]; ?></label>
                <button type="submit" id="logout_button">Log out</button>
            </form>
        <?php
        } else {
        ?>
            <a href="/chord-visualizer/login" class="navbar login_button", type>Log in</a>";
        <?php
        }
        ?>
    </nav>


</body>