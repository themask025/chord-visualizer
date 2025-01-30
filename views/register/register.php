<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Registration Form</title>
  <?php
  require_once( __DIR__ . '/../../constants.php');
  require_once(__DIR__ . "/../navigation_bar/index.php");
  echo '<link rel="stylesheet"' . ' href="' . BASE_PATH . 'views/register/register.css" />';
  ?>
</head>

<body>
  <form class="register-form" method="post">
    <?php
    if ($this->error != null) {
      echo "<p class=\"error-message\">" . $this->error . "</p>";
    }
    ?>
    <label class="input-label" for="username">Username:</label>
    <input class="form-input" type="text" id="username" name="username" placeholder="Username" required>

    <label class="input-label" for="email">Email:</label>
    <input class="form-input" type="email" id="email" name="email" placeholder="Email" required>

    <label class="input-label" for="password">Password:</label>
    <input class="form-input" type="password" id="password" name="password" placeholder="Password" required>

    <label class="input-label" for="password_confirmation">Repeat password:</label>
    <input class="form-input" type="password" id="password_confirmation" name="password_confirmation"
      placeholder="Confirm Password" required>

    <button class="submit-button" type="submit">Sign up</button>
    <div class="login-text">
      <p class="login-link">Or</p>
      <a class="login-link" href="<?php echo BASE_PATH; ?>login">Log in</a>
    </div>

  </form>
</body>

</html>