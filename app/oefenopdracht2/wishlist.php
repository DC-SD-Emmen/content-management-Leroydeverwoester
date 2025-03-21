<?php
    session_start(); // Start de session 

    spl_autoload_register(function ($class) {
        include 'classes/' . $class . '.php';
    });

    $db = new Database();
    $conn = $db->getConnection();
    $gameManager = new GameManager($db);

    // Check if the user is logged in
    if (!isset($_SESSION['username'])) {
        header("Location: inloggen.php");
        exit;
    }

    if (isset($_GET['search'])) {
        $searchTerm = htmlspecialchars($_GET['search']);
        $games = $gameManager->searchGames($searchTerm);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stijl.css">
    <title>Wishlist</title>
</head>
<body>
    <canvas id="gradient-canvas"></canvas>
    
    <div class="gridItem">
            <div id=communityLibrary> <p id="Buttonz" onclick="window.location.href='index.php'">LIBRARY</p> </div>
            <div id=storeLibrary> <p id="Buttonz" onclick="window.location.href='store.php'">STORE</p> </div>

            <?php if (isset($_SESSION['username']) && $_SESSION['username'] === 'Admin'): ?>
                <div id=add_gameLibrary> <p id="Buttonz" onclick="window.location.href='add_game.php'">ADD GAME</p> </div>
            <?php endif; ?>

            <div id=communityLibrary><p id="Buttonz" onclick="window.location.href='login.php'">LOGIN</p> </div>
            <div id=libraryLibrary> <p id="Buttonz" onclick="window.location.href='user.php'">ACCOUNT</p> </div>
    </div>
</body>
</html>

<?php
    $userManager = new UserManager($conn);
    $user = $userManager->getUser($_SESSION['username']);
    $user_id = $user['id'];

    if (isset($_GET['action']) && $_GET['action'] == 'add_to_wishlist' && isset($_GET['game_id'])) {
        $game_id = intval($_GET['game_id']);
        $userManager->connection_user_games($user_id, $game_id);
    }

    if (isset($_GET['action']) && $_GET['action'] == 'remove_from_wishlist' && isset($_GET['game_id'])) {
        $game_id = intval($_GET['game_id']);
        $userManager->removeFromWishlist($user_id, $game_id);
    }

    $wishlistQuery = "
        SELECT games.id, games.title, games.image, games.developer, games.rating, games.genre, games.release_year
        FROM games
        INNER JOIN user_games ON games.id = user_games.game_id
        WHERE user_games.user_id = :user_id;
    ";

    $stmt = $conn->prepare($wishlistQuery);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $wishlistGames = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo "<h2>" . htmlspecialchars($_SESSION['username']) . "'s Wishlist</h2>";
        
        echo "<div class='wishlistgrid'>";
            if (count($wishlistGames) > 0) {
                echo "<ul>";
                    foreach ($wishlistGames as $game) {
                        echo "<div class='wishlistColumn'>";
                            echo '<a href="game_details.php?id=' . urlencode($game['id']) . '">';
                            echo '<img id="imagetitle" src="uploads/' . htmlspecialchars($game['image']) . '" alt="' . htmlspecialchars($game['title']) . '"></a>';

                            echo "<div class='wish-info'>";
                                echo "<li class='wishtitle'>" . htmlspecialchars($game['title']) . "</li> " . "<br>"; 
                                echo "<li>" . htmlspecialchars($game['developer']) . "</li>" . "<br>";
                                echo "<li class='game-release-year'>" . htmlspecialchars($game['release_year']) . "</li> <br>"; 
                                echo '<li class="game-rating">Rating: ' . number_format($game['rating'], 1) . '/10</li>' ; 
                                echo '<p class="game-genre">Genre: ' . htmlspecialchars($game['genre']) . '</p> <br>';
                                echo '<a href="wishlist.php?action=remove_from_wishlist&game_id=' . urlencode($game['id']) . '" class="add_to_wishlist">Remove 🗑️</a>';
                                echo '<a href="index.php?action=buy&game_id=' . urlencode($game['id']) . '" class="buy">Buy game 🛒</a>';
                            echo "</div>";
                        echo "</div>";
                    }
                echo "</ul>";
            } else {
                echo "<p>Your wishlist is empty.</p>";
            }
        echo "</div>";
?>

<script src="background.js"></script>