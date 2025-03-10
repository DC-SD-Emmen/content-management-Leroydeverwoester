<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="stijl.css">
</head>
<body>
<canvas id="gradient-canvas"></canvas>
        <!-- include class -->
        <?php

spl_autoload_register(function($class){
    include "classes/" . $class . ".php";
});

$db = new Database();

$gameManager = new GameManager($db);

$games = $gameManager->getGames();

// navbar
?>

    
            <div class="gridItem">
            <div id=communityLibrary> <p id="Buttonz" onclick="window.location.href='index.php'">LIBRARY</p> </div>
                <div id=libraryLibrary> <p id="Buttonz" onclick="window.location.href='store.php'">STORE</p> </div>
                <div id=add_gameLibrary> <p id="Buttonz" onclick="window.location.href='add_game.php'">ADD GAME</p> </div>
                <div id=communityLibrary><p id="Buttonz" onclick="window.location.href='register.php'">REGISTER</p> </div>
                <div id=add_gameLibrary> <p id="Buttonz" onclick="window.location.href='user.php'">ACCOUNT</p> </div>
        </div>
        <div class="sidebar">
     

    </div>
</body>
</html>

<script src="background.js"></script>
