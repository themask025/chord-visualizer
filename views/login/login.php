<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login Form</title>
    <?php
        require_once 'constants.php';
        echo '<link rel="stylesheet"' . ' href="'. BASE_PATH . 'views/login/login.css" />';
    ?>
    <!--<link rel="stylesheet" href="/chord-visualizer/views/login/login.css" />-->
    <!-- When path begin / is absolute path from the root folder-->
    <!-- otherwise it is relative path from the current folder -->
</head>
<body>
<h1 class="title">Login</h1>
<form class="login-form" method="post">
  <label for="email">Email:</label>
  <input class="form-input" type="email" id="email" name="email" required>

  <label for="password">Password:</label>
  <input class="form-input" type="password" id="password" name="password" required>

  <button class="submit-button" type="submit">Register</button>
</form>
</body>
</html>