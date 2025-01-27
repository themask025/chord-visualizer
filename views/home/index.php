<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Landing page</title>
</head>

<body>
    <?php 
    // require_once "constants.php";
    // require_once BASE_PATH . 'models/database.php';

    session_start();

    if (isset($_SESSION["user_id"])) 
    {
        // $db = new Database();
        // $db->query("SELECT * FROM users WHERE id=:id");
        // $db->bind(":id", $_SESSION["user_id"]);
        // $user = $db->fetchSingleResult();
        // echo "<h1 class=\"title\">Hello, " . $user["username"] . "</h1>";
        echo "<h1 class=\"title\">Hello, " . $_SESSION["user_id"] . "</h1>";
    } 
    else 
    { 
        ?>
        <h1 class="title">Not logged in</h1>
        <!-- <a href="<?//BASE_PATH?>register">Register</a>
        <a href="<?//BASE_PATH?>login">Login</a> -->
        <?php 
    }
    ?>
</body>

</html>