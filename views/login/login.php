<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Login Form</title>
  <?php
  require_once (__DIR__ . '/../../constants.php');
  require_once(__DIR__ . "/../navigation_bar/index.php");
  echo '<link rel="stylesheet"' . ' href="' . BASE_PATH . 'views/login/login.css" />';
  ?>
</head>

<body>
  <form class="login-form" method="post">
    <?php
    if ($this->error != null) {
      echo "<p class=\"error-message\">" . $this->error . "</p>";
    }
    ?>
    <label class="input-label" for="username">Username:</label>
    <input class="form-input" type="text" id="username" name="username" placeholder="Username" required>

    <label class="input-label" for="password">Password:</label>
    <input class="form-input" type="password" id="password" name="password" placeholder="Password" required>

    <button class="submit-button" type="submit">Login</button>
    <div class="register-text">
      <p class="register-link">Or</p>
      <a class="register-link" href="<?php echo BASE_PATH; ?>register">Sign up</a>
    </div>
  </form>
</body>

</html>