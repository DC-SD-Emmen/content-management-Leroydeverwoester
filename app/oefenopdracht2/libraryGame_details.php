<?php 
    session_start();

    spl_autoload_register(function($class) { 
        include "classes/" . $class . ".php";
    });

    $db = new Database();
    $gameManager = new GameManager($db);

    $id = $_GET['id'];
    $game = $gameManager->getGame($id);

    if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['game_id'])) {
        $game_id = intval($_GET['game_id']);
        $userManager->delete($user_id, $game_id);
    }
?>

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

    <div class="gridLibrary">
        <div class="gridItem">
            <div id="libraryLibrary"><p id="Buttonz" onclick="window.location.href='index.php'">LIBRARY</p></div>
            <div id=storeLibrary> <p id="Buttonz" onclick="window.location.href='store.php'">STORE</p> </div>

            <?php if (isset($_SESSION['username']) && $_SESSION['username'] === 'Admin'): ?>
                <div id=add_gameLibrary> <p id="Buttonz" onclick="window.location.href='add_game.php'">ADD GAME</p> </div>
            <?php endif; ?>

            <div id=communityLibrary><p id="Buttonz" onclick="window.location.href='login.php'">LOGIN</p> </div>
            <div id=add_gameLibrary> <p id="Buttonz" onclick="window.location.href='user.php'">ACCOUNT</p> </div>
        </div>

        <div class="game-details">
            <div class='leftinfo'>
                <img class="game-image" src="uploads/<?php echo htmlspecialchars($game->getImage()); ?>" alt="Game Image"> <br>
                <a href="index.php?action=delete&game_id=<?php echo urlencode($game->getId()); ?>" class="add_to_wishlist" onclick="return confirm('Are you sure you want to delete this game?');">Delete 🗑️</a>
            </div>

            <div class="game-info">
                <h1 class="gamez-title"><?php echo htmlspecialchars($game->getTitle()); ?></h1>
                <p class="game-genre">Genre: <?php echo htmlspecialchars($game->getGenre()); ?></p>
                <p class="game-genre">Platform: <?php echo htmlspecialchars($game->getPlatform()); ?></p>
                <p class="game-rating">Rating: <?php echo number_format($game->getRating(), 1); ?>/10</p>
                <p class="game-description"><?php echo htmlspecialchars($game->getDescription()); ?></p>
                <p class="game-release-year">Release Year: <?php echo htmlspecialchars($game->getRelease_year()); ?></p>
                <p class="game-developer">Developer: <?php echo htmlspecialchars($game->getDeveloper()); ?></p>
            </div>
        </div>
    </div>
</body>
</html>

<script src="background.js"></script>
