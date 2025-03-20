<?php

    session_start();

    spl_autoload_register(function($class){
        include "classes/" . $class . ".php";
    });

    $database = new Database();
    $userManager = new UserManager($database->getConnection());
  

    $user = null;
    if (isset($_SESSION['username'])) {
        $user = $userManager->getUser($_SESSION['username']);
    }
    // Remove this redundant block




    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if(isset($_POST['register'])) {
            
            $username = $_POST['username'];
            $email = isset($_POST['email']) ? $_POST['email'] : null;
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

            $result = $userManager->insertUser($username, $email, $password);

            if ($result) {
                echo "<div class='success'>Registration success!</div>";
            }

        }
    }

    if (isset($_GET['action']) && $_GET['action'] === 'deleteAccount') {
        // Retrieve user data from the database
        $stmt = $database->getConnection()->prepare("SELECT * FROM users WHERE username = :currentUsername");
        $stmt->bindParam(':currentUsername', $_SESSION['username']);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Delete user from the database
            $stmt = $database->getConnection()->prepare("DELETE FROM users WHERE username = :currentUsername");
            $stmt->bindParam(':currentUsername', $_SESSION['username']);
            $stmt->execute();

            // Delete user using UserManager
            $userManager->deleteAccount($user['id']);
        }
    
        // Destroy the session and redirect to the login page
        session_destroy();
        header("Location: login.php");
        exit;
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
            <p>Create an account to add games to your library!</p> <br>
                <form action="register.php" method="post">

                Username: <br>
                    <input type="text" name="username" placeholder="Create new username" required> <br> 

                E-Mail <br>
                    <input type="email" name="email" placeholder="Enter your e-mail" required> <br> 

                Password: <br>
                    <input type="password" name="password" placeholder="Create new password" required> <br> 

                <input type="submit" value="Register" name='register'>

            <p>Or <a href="login.php">Login here</a></p>

        </div>

    

</body>
</html>

<script src="background.js"></script>


