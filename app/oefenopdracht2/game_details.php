<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Details</title>
    <link rel="stylesheet" href="steam_style.css">
    <link rel="stylesheet" href=stijl.css>
</head>
<body>
<canvas id="gradient-canvas"></canvas>
<?php
    spl_autoload_register(function($class) { 
        include "classes/" . $class . ".php";
    });

    $db = new Database();
    $gameManager = new GameManager($db);

    $id = $_GET['id'];
    $game = $gameManager->getGame($id);
?>

<!-- Top Navigation -->
<div class="gridLibrary">
    <div class="gridItem">
    <div id="libraryLibrary"><p id="Buttonz" onclick="window.location.href='index.php'">LIBRARY</p></div>
    <div id=storeLibrary> <p id="Buttonz" onclick="window.location.href='store.php'">STORE</p> </div>
    <div id=add_gameLibrary> <p id="Buttonz" onclick="window.location.href='add_game.php'">ADD GAME</p> </div>
    <div id=communityLibrary><p id="Buttonz" onclick="window.location.href='register.php'">REGISTER</p> </div>
    <div id=add_gameLibrary> <p id="Buttonz" onclick="window.location.href='user.php'">ACCOUNT</p> </div>
</div>


<!-- Game Details -->
<div class="game-details">
    <img class="game-image" src="uploads/<?php echo htmlspecialchars($game->getImage()); ?>" alt="Game Image">
    <div class="game-info">
    <h1 class="gamez-title"><?php echo htmlspecialchars($game->getTitle()); ?></h1>
    <p class="game-genre">Genre: <?php echo htmlspecialchars($game->getGenre()); ?></p>
    <p class="game-genre">Platform: <?php echo htmlspecialchars($game->getPlatform()); ?></p>
    <p class="game-rating">Rating: <?php echo number_format($game->getRating(), 1); ?>/10</p>
    <p class="game-description"><?php echo htmlspecialchars($game->getDescription()); ?></p>
    <p class="game-release-year">Release Year: <?php echo htmlspecialchars($game->getRelease_year()); ?></p>
    <p class="game-developer">Developer: <?php echo htmlspecialchars($game->getDeveloper()); ?></p>
    <p class="add-wishlist"><a href="wishlist.php?id=<?php echo urlencode($game->getId()); ?>">Add to Wishlist</a></p>
</div>
</div>

</body>
</html>

<script src="background.js"></script>
