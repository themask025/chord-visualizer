<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login Form</title>
    <?php
    require_once 'constants.php';
    echo '<link rel="stylesheet"' . ' href="' . BASE_PATH . 'views/login/login.css" />';
    ?>
</head>

<body>
<h1 class="title">Login</h1>
<form class="login-form" method="post">
    <label for="username">Username:</label>
    <input class="form-input" type="text" id="username" name="username" required>

    <label for="password">Password:</label>
    <input class="form-input" type="password" id="password" name="password" required>

    <button class="submit-button" type="submit">Register</button>
</form>
<a href="controllers/RegisterController">or Sign up</a>
</body>

</html>