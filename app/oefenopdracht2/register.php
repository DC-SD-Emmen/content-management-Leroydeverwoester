<?php


spl_autoload_register(function($class){
    include "classes/" . $class . ".php";
});

$database = new Database();
$userManager = new UserManager($database->getConnection());


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if(isset($_POST['register'])) {
        $username = $_POST['username'];
        $email = isset($_POST['email']) ? $_POST['email'] : null;
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

        if (is_null($email)) {
            echo "Email is required.";
            exit();
        }

        $userManager->insertUser($username, $email, $password);
    }
}

?>

<html>
<head>
    <title>Drenthe College docker web server</title>
    <!-- <link rel="stylesheet" type="text/css" href="style.css"> -->
    <link rel="stylesheet" type="text/css" href="stijl.css">
    <link rel="stylesheet" type="text/css" href="steam_style.css">
</head>
<body>
<canvas id="gradient-canvas"></canvas>
<div class="gridItem">

    <div id=communityLibrary> <p id="Buttonz" onclick="window.location.href='index.php'">LIBRARY</p> </div>
    <div id=storeLibrary> <p id="Buttonz" onclick="window.location.href='store.php'">STORE</p> </div>
    <div id=add_gameLibrary> <p id="Buttonz" onclick="window.location.href='add_game.php'">ADD GAME</p> </div>
    <div id=libraryLibrary> <p id="Buttonz" onclick="window.location.href='register.php'">REGISTER</p> </div>
    <div id=add_gameLibrary> <p id="Buttonz" onclick="window.location.href='user.php'">ACCOUNT</p> </div>
</div>
    <div class="container">
        <p>Please fill in this form to create a new account.</p> <br>
        <form action="register.php" method="post">
        Username: <br>
        <input type="text" name="username" placeholder="Create new username" required> <br> 
        E-Mail <br>
        <input type="email" name="email" placeholder="Enter your e-mail" required> <br> 
        Password: <br>
        <input type="password" name="password" placeholder="Create new password" required> <br> 
        <input type="submit" value="Register" name='register'>

        <p>Already have an account? <a href="login.php">Login here</a></p>

</div>

    </form>
</body>
</html>

<script src="background.js"></script>


