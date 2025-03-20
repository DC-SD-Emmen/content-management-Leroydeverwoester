<?php

    session_start();

    spl_autoload_register(function($class){
        include "classes/" . $class . ".php";
    });

    $database = new Database();
    $userManager = new UserManager($database->getConnection());


    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if(isset($_POST['login'])) {

            $username = htmlspecialchars($_POST['username'] ?? '');
            $password = $_POST['password'];
            
            $user = $userManager->getUser($username);
        
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['username'] = $username;
                header("Location: user.php");
            } else {
                echo "Login failed!";
            }
        }
    }

    if (isset($_GET['search'])) {
        $searchTerm = htmlspecialchars($_GET['search']);
        $games = $gameManager->searchGames($searchTerm);
    }

?>


<html>
<head>
    <title>Drenthe College docker web server</title>
    <link rel="stylesheet" href="stijl.css">
    <link rel="stylesheet" href="steam_style.css">
</head>

<body>
    <canvas id="gradient-canvas"></canvas>

    <div class="gridItem">
        <div id=communityLibrary> <p id="Buttonz" onclick="window.location.href='index.php'">LIBRARY</p> </div>
        <div id=storeLibrary> <p id="Buttonz" onclick="window.location.href='store.php'">STORE</p> </div>
        <?php if (isset($_SESSION['username']) && $_SESSION['username'] === 'Admin'): ?>
            <div id=add_gameLibrary> <p id="Buttonz" onclick="window.location.href='add_game.php'">ADD GAME</p> </div>
                <?php endif; ?>
        <div id=libraryLibrary> <p id="Buttonz" onclick="window.location.href='login.php'">LOGIN</p> </div>
        <div id=add_gameLibrary> <p id="Buttonz" onclick="window.location.href='user.php'">ACCOUNT</p> </div>

    </div>
            
    <div class="container">
        <p>Please fill in to get access to your account.</p> <br>
            <form action='' method="post">
                Username: <br>
                <input type="text" name="username" placeholder="Enter your username" required> <br> 
                E-Mail <br>
                <input type="email" name="email" placeholder="Enter your e-mail" required> <br> 
                Password: <br>
                <input type="password" name="password" placeholder="Enter your password" required> <br> 
                <input type="submit" value="Login" name='login'>

                <p>New user? <a href="register.php">Register here</a></p>
            </form>
    </div>

   
   
</body>
</html>

<script src="background.js"></script>
