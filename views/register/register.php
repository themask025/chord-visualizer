<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Registration Form</title>
    <?php
    require_once 'constants.php';
    echo '<link rel="stylesheet"' . ' href="'. BASE_PATH . 'views/register/register.css" />';
    ?>
</head>
<body>
<h1 class="title">Register</h1>
<?php
    if($this->error != null)
    {
      echo "<h2 class=\"title\">" . $this->error . "</h2>";
    }
  ?>
<form class="register-form" method="post">
  <label for="username">Username:</label><br>
  <input class="form-input" type="text" id="username" name="username" required><br><br>

  <label for="email">Email:</label><br>
  <input class="form-input" type="email" id="email" name="email" required><br><br>

  <label for="password">Password:</label><br>
  <input class="form-input" type="password" id="password" name="password" required><br><br>
  
  <label for="password">Repeat password:</label><br>
  <input class="form-input" type="password" id="password_confirmation" name="password_confirmation" required><br><br>

  <button class="submit-button" type="submit">Register</button>
  <a href="<?php echo BASE_PATH; ?>login">Or Log in</a>

</form>
</body>
</html>