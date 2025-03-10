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

    <div class="container">
    <h1>Welcome <?php echo $_SESSION['username']; ?></h1>
    <p>You are now logged in.</p>
    <br>
    <button onclick="window.location.href='wishlist.php'">Show Wishlist</button>
    <?php
    $funFacts = [
        "The highest-grossing video game of all time is Minecraft.",
        "The first video game ever created was Pong.",
        "The longest gaming session recorded lasted over 35 hours.",
        "The PlayStation 2 is the best-selling game console of all time.",
        "The character Mario was originally called Jumpman.",
        "The first video game to be played in space was Tetris.",
        "The world record for the fastest completion of Super Mario Bros. is under 5 minutes.",
        "The most expensive video game ever developed was Grand Theft Auto V.",
        "The first eSports tournament was held in 1972 for the game Spacewar!",
        "The game Pac-Man was inspired by a pizza with a slice missing.",
        "The first gaming console to have internal memory was the Sega Saturn.",
        "The original name for the Xbox was DirectX Box.",
        "The game 'E.T. the Extra-Terrestrial' for Atari 2600 is often considered the worst video game ever made.",
        "The character Sonic the Hedgehog was originally going to be a rabbit.",
        "The game 'The Legend of Zelda: Ocarina of Time' is often considered one of the greatest games of all time.",
        "The first 3D game was '3D Monster Maze' released in 1981.",
        "The game 'World of Warcraft' has over 100 million registered accounts.",
        "The longest-running video game series is 'The Oregon Trail', first released in 1971.",
        "The first Ratchet & Clank game was released in 2002.",
        "Ratchet & Clank was developed by Insomniac Games.",
        "The Ratchet & Clank series has sold over 26 million copies worldwide.",
        "Ratchet & Clank: Up Your Arsenal introduced online multiplayer to the series.",
        "The character Ratchet is a Lombax, a fictional species.",
        "Clank, Ratchets companion, is a small robot with advanced intelligence.",
        "Ratchet & Clank: Rift Apart was released for the PlayStation 5 in 2021.",
        "The series Ratchet & Clank is known for its unique and imaginative weapons and gadgets.",
        "A Ratchet & Clank animated movie was released in 2016.",
        "The game 'The Witcher 3: Wild Hunt' has over 36 different endings.",
        "The game 'Red Dead Redemption 2' features over 200 species of animals.",
        "The game 'The Elder Scrolls V: Skyrim' has been released on more than 15 different platforms.",
        "The game 'Fortnite' holds the record for the most concurrent players, with over 10 million players online at once.",
        "The game 'Among Us' became a global sensation during the COVID-19 pandemic.",
        "The game 'Cyberpunk 2077' had one of the most anticipated releases in gaming history.",
        "The game 'Animal Crossing: New Horizons' was a major hit during the COVID-19 lockdowns.",
        "The game 'League of Legends' has over 100 million active players each month.",
        "The game 'Minecraft' has sold over 200 million copies worldwide.",
        "The game 'The Legend of Zelda: Breath of the Wild' is often praised for its open-world design.",
        "The game 'Dark Souls' is known for its high difficulty and intricate level design.",
        "The game 'Overwatch' has a diverse cast of characters from various backgrounds.",
        "The game 'Hades' won several Game of the Year awards in 2020.",
        "The game 'Stardew Valley' was developed by a single person, Eric Barone.",
        "The game 'Doom' (1993) is considered one of the most influential first-person shooters of all time.",
        "King Julien is a character from the Madagascar movie series.",
        "King Julien is voiced by actor Sacha Baron Cohen in the movies.",
        "King Julien is the self-proclaimed 'King of the Lemurs' in Madagascar.",
        "King Julien has his own spin-off TV series called 'All Hail King Julien'.",
        "King Julien is known for his love of dancing and partying.",
        "King Julien's full name is King Julien XIII.",
        "King Julien's catchphrase is 'I like to move it, move it!'",
        "King Julien often relies on his advisor, Maurice, for help.",
        "King Julien has a loyal follower named Mort, who adores him.",
        "King Julien is known for his eccentric and flamboyant personality."
    ];

    $randomFact = $funFacts[array_rand($funFacts)];
    ?>
    <p>Fun Fact: <?php echo $randomFact; ?></p>
        <a href="user.php?action=logout">Log out</a>
    </div>

</body>
</html>

<script src="background.js"></script>
