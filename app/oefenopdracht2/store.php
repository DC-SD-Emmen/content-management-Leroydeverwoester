<?php
    session_start();

    spl_autoload_register(function($class){
        include "classes/" . $class . ".php";
    });

    if (!isset($_SESSION['username'])) {
        header("Location: login.php");
        exit;
    }
    
    $db = new Database();

    $gameManager = new GameManager($db);

    $games = $gameManager->getGames();

    if (isset($_GET['search'])) {
        $searchTerm = htmlspecialchars($_GET['search']);
        $games = $gameManager->searchGames($searchTerm);
    }

    if (isset($_GET['action']) && $_GET['action'] == 'remove' && isset($_GET['id'])) {
        $id = intval($_GET['id']);
        $gameManager->remove($id);
    }
?>

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
    
    <div class="searchdiv">
        <div class="search-container">
            <form action="store.php" method="GET">
                <input class="search" type="search" name="search" placeholder="Search for titles, genres etc...">
            </form>
        </div>
    </div>
    
    <div class="gridItem">
        <div id=communityLibrary> <p id="Buttonz" onclick="window.location.href='index.php'">LIBRARY</p> </div>
            <div id=libraryLibrary> <p id="Buttonz" onclick="window.location.href='store.php'">STORE</p> </div>
            
            <?php if (isset($_SESSION['username']) && $_SESSION['username'] === 'Admin'): ?>  
                <div id=add_gameLibrary> <p id="Buttonz" onclick="window.location.href='add_game.php'">ADD GAME</p> </div>
            <?php endif; ?>

            <div id=communityLibrary><p id="Buttonz" onclick="window.location.href='login.php'">LOGIN</p> </div>
            <div id=add_gameLibrary> <p id="Buttonz" onclick="window.location.href='user.php'">ACCOUNT</p> </div>
        </div>
    </div>
   
    <div class="store-game-boxes">
        <?php
            foreach ($games as $game) {
                echo '<div class="game-box">';
                    echo '<a href="game_details.php?id=' . urlencode($game->getId()) . '">';
                    echo '<img id="imagetitle" src="uploads/' . htmlspecialchars($game->getImage()) . '" alt="' . htmlspecialchars($game->getTitle()) . '"></a>';
                echo '</div>';
            }
        ?>
    </div>
</body>
</html>

<script src="background.js"></script>
