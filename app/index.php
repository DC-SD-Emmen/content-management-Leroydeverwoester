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
</head>
<body>
    <h1>Registration form</h1>

    <form action="index.php" method="post">
        Username: <br>
        <input type="text" name="username" placeholder="Enter your username" required> <br> <br>
        Password: <br>
        <input type="password" name="password" placeholder="Enter your password" required> <br> <br>
        <input type="submit" value="Register">
    </form>
</body>
</html>