<?php
        session_start();

            // Check if the user is logged in
            if (!isset($_SESSION['username'])) {
            header("Location: login.php");
            exit;
        }

        spl_autoload_register(function($class){
            include "classes/" . $class . ".php";
        });

        $db = new Database();

        $gameManager = new GameManager($db);

        $games = $gameManager->getGames();

        $conn = $db->getConnection();

        // navbar
    
        $userManager = new UserManager($conn);
        $user = $userManager->getUser($_SESSION['username']);
        if (!$user) {
            echo "Error: User not found.";
            exit;
        }
        $user_id = $user['id'];
    
        if (isset($_GET['action']) && $_GET['action'] == 'buy' && isset($_GET['game_id'])) {
            $game_id = intval($_GET['game_id']);
            $userManager->connection_bought_games($user_id, $game_id);
        }
    
        $buyQuery = "
            SELECT games.title, games.image, games.id
            FROM games
            INNER JOIN bought_games ON games.id = bought_games.game_id
            WHERE bought_games.user_id = :user_id;
        ";

        $stmt = $conn->prepare($buyQuery);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        $buygames = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (isset($_GET['search'])) {
            $searchTerm = htmlspecialchars($_GET['search']);
            $buygames = $gameManager->searchBoughtGames($searchTerm, $user_id);
        }

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
    <title>Document</title>
    <link rel="stylesheet" href="stijl.css">
    
</head>
<body>

    <canvas id="gradient-canvas"></canvas>
    <div class="gridLibrary">
          <div class="searchdiv">
            <div class="search-container">
            <form action="index.php" method="GET">
                <input class="search" type="search" name="search" placeholder="Browse library...">
            
             
                </form>
            </div>
        </div>
          
        </div>
        <div class="gridItem">
                <div id=libraryLibrary> <p id="Buttonz" onclick="window.location.href='index.php'">LIBRARY</p> </div>
                <div id=storeLibrary> <p id="Buttonz" onclick="window.location.href='store.php'">STORE</p> </div>
                <?php if (isset($_SESSION['username']) && $_SESSION['username'] === 'Admin'): ?>
            <div id=add_gameLibrary> <p id="Buttonz" onclick="window.location.href='add_game.php'">ADD GAME</p> </div>
                <?php endif; ?>
                <div id=communityLibrary><p id="Buttonz" onclick="window.location.href='login.php'">LOGIN</p> </div>
                <div id=add_gameLibrary> <p id="Buttonz" onclick="window.location.href='user.php'">ACCOUNT</p> </div>
                
            </div>
            </div>
        
        <div class="gameGrid">
    

            <?php

if (isset($_GET['search']) && empty($buygames)) {
    
    echo '<p class="msg"> You don\'t own a game called: "' . htmlspecialchars($_GET['search']) . '". Instead, search for "' . htmlspecialchars($_GET['search']) . '" in the <a class="storebutton" href="store.php?search=' . urlencode($_GET['search']) . '">STORE</a>.</p>';

}

            
            if (count($buygames) > 0) {
                
                echo "<div class='sidebar'>";
                foreach ($buygames as $game) {
                    echo '<div class="game-bar">';
                                echo '<a class="gameLink" href="libraryGame_details.php?id=' . urlencode($game['id']) . '">';
                                                echo '<img class="game-image" id="imageside" src="uploads/' . htmlspecialchars($game['image']) . '" alt="' . htmlspecialchars($game['title']) . '">';
                                                echo '<div class="game-title">' . htmlspecialchars($game['title']) . '</div>';
                                echo '</a>';
                            echo '</div>';
                }
                
                    echo "</div>";
            } 


                if (count($buygames) > 0) {
                echo "<div class='game-boxes'>";
                foreach ($buygames as $game) {
                    echo '<div class="game-box">';
                        echo '<a href="libraryGame_details.php?id=' . urlencode($game['id']) . '">';
                        echo '<img id="imagetitle" src="uploads/' . htmlspecialchars($game['image']) . '" alt="' . htmlspecialchars($game['title']) . '"></a>';
                    echo '</div>';
                }
                
                    echo "</div>";

            } else if (empty($buygames) && !isset($_GET['search'])) {
                echo '<p class="msg">Hey it\'s a little empty here... You can purchase some games at the <a class="storebutton" href="store.php' . (isset($_GET['search']) ? '?search=' . urlencode($_GET['search']) : '') . '">STORE</a>.</p>';
            }

            ?>
                

    </div>
    
</body>
</html>

<script src="background.js"></script>

    
    

