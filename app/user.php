<?php

$host = "mysql";
$dbname = "user_login"; 
$charset = "utf8";
$port = "3306";

spl_autoload_register(function($class){
    include __DIR__ . "/" . $class . ".php";
});


session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    session_destroy();
    header("Location: login.php");
    exit;
}

echo "U bent ingelogd.";

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    
    <div class="header">
    <h1>Welkom op de user pagina</h1>
    </div>
    <div class="container">
        <a href="user.php?action=logout">Log out</a>
    

</div>
    </form>
</body>
</html>