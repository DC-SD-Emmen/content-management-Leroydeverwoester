<?php

$host = "mysql";
$dbname = "user_login"; 
$charset = "utf8";
$port = "3306";

spl_autoload_register(function($class){
    include __DIR__ . "/" . $class . ".php";
});
?>

<html>
<head>
    <title>Drenthe College docker web server</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <div class="header">
        <h1>Login</h1>
    </div>
    <div class="container">
        <p>Please fill in this form to login to your account.</p> <br>
        <form action="index.php" method="post">
        Username: <br>
        <input type="text" name="username" placeholder="Enter your username" required> <br> <br>
        Password: <br>
        <input type="password" name="password" placeholder="Enter your password" required> <br> <br>
        <input type="submit" value="Login">

        <p>Don't own an account? <a href="index.php">Register here</a></p>

</div>
    </form>
</body>
</html>