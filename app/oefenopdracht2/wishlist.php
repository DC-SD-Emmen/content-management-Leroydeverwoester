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

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="stijl.css">
</head>
<body>
<canvas id="gradient-canvas"></canvas>
<div class="gridItem">

<div id=communityLibrary> <p id="Buttonz" onclick="window.location.href='index.php'">LIBRARY</p> </div>
<div id=storeLibrary> <p id="Buttonz" onclick="window.location.href='store.php'">STORE</p> </div>
<div id=add_gameLibrary> <p id="Buttonz" onclick="window.location.href='add_game.php'">ADD GAME</p> </div>
<div id=add_gameLibrary> <p id="Buttonz" onclick="window.location.href='register.php'">REGISTER</p> </div>
<div id=libraryLibrary> <p id="Buttonz" onclick="window.location.href='user.php'">ACCOUNT</p> </div>
</div>



</body>
</html>

<script src="background.js"></script>
