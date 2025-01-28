<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Landing page</title>
</head>

<body>
    <?php 
    session_start();

    if (isset($_SESSION["user_id"])) 
    {
        echo "<h1 class=\"title\">Hello, " . $_SESSION["username"] . "</h1>";
    } 
    else 
    { 
        echo "<h1 class=\"title\">Not logged in</h1>";
    }
    ?>
</body>

</html>