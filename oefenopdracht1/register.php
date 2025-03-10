<?php

$host = "mysql";
$dbname = "user_login"; 
$charset = "utf8";
$port = "3306";

spl_autoload_register(function($class){
    include __DIR__ . "/" . $class . ".php";
});

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $database = new Database();
    $conn = $database->getConnection();

    if ($conn) {
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        
        if ($stmt->execute()) {
            echo "Registration success!";
        } else {
            echo "Database connection failed.";
        }
        
    }
}


?>

<html>
<head>
    <title>Drenthe College docker web server</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="oefenopdracht2/stijl.css">
    <link rel="stylesheet" type="text/css" href="oefenopdracht2/steam_style.css">
</head>
<body>
 
<div class="gridItem">

    <div id=libraryLibrary> <p id="Buttonz" onclick="window.location.href='index.php'">STORE</p> </div>
    <div id=storeLibrary> <p id="Buttonz" onclick="window.location.href='library.php'">LIBRARY</p> </div>
    <div id=communityLibrary> <p id="Buttonz"> COMMUNITY</p> </div>
    <div id=add_gameLibrary> <p id="Buttonz" onclick="window.location.href='add_game.php'">ADD GAME</p> </div>
    <div id=Register> <p id="Buttonz" onclick="window.location.href='oefenopdracht1/index.php'">REGISTER</p> </div>
</div>
    <div class="container">
        <p>Please fill in this form to create a new account.</p> <br>
        <form action="index.php" method="post">
        Username: <br>
        <input type="text" name="username" placeholder="Create new username" required> <br> <br>
        Password: <br>
        <input type="password" name="password" placeholder="Create new password" required> <br> <br>
        <input type="submit" value="Register">

        <p>Already have an account? <a href="login.php">Login here</a></p>

</div>

    </form>
</body>
</html>


