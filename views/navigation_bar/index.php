<!DOCTYPE html>
<html lang="en">

<?php
require_once(__DIR__ . "/../../constants.php");
?>

<head>
    <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>
    <link rel="stylesheet" href="<?php echo BASE_PATH; ?>views/navigation_bar/styles.css">
</head>

<nav class="navbar">
    <a href="<?php echo BASE_PATH; ?>" class="logo">CHORD VISUALIZER</a>

    <?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (isset($_SESSION["user_id"])) {
        ?>
        <form action="<?php echo BASE_PATH; ?>login/logout" method="post" class="logout-form">
            <input type="text" name="sender" value="<?php echo $_SERVER['REQUEST_URI']; ?>" hidden />
            <label for="logout-button" class="username"><?php echo $_SESSION["username"]; ?></label>
            <button type="submit" id="logout-button" class="logout-button" /></button>
        </form>
        <?php
    } else if (!isset($data["auth_page"]) || $data["auth_page"] != true) {
        ?>
            <a href="<?php echo BASE_PATH; ?>login" class="login-button"><img src="<?php echo BASE_PATH; ?>assets/icon_log_in.png"
                    alt="Log in icon"></a>
        <?php
    }
    ?>
</nav>