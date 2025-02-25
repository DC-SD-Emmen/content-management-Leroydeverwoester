<?php

$host = "mysql";
$dbname = "user_login"; 
$charset = "utf8";
$port = "3306";

spl_autoload_register(function($class){
    include __DIR__ . "/" . $class . ".php";
});

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = htmlspecialchars($_POST['username'] ?? '');
    $password = htmlspecialchars($_POST['password'] ?? '');
    $errors = [];

    if (empty($errors)) {
        verify_password();
    } else {
        echo '<div style="color: red;">';
        foreach ($errors as $error) {
            echo "<p>$error</p>";
        }
        echo '</div>';
    }
}

function verify_password() {
    $username = $_POST['username'];
    $password = $_POST['password'];
    // Validate input
    if (empty($username) || empty($password)) {
        echo "Gebruikersnaam en wachtwoord zijn verplicht.";
        exit;
    }
    $database = new Database();
    $conn = $database->getConnection();
    // Sanitize input
    $username = htmlspecialchars($username);
    $password = htmlspecialchars($password);
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch();
    if ($user && password_verify($password, $user['password'])) {
        session_start();
        $_SESSION['username'] = $user['username'];
        header("Location: user.php?id=" . $user['username']);
        echo "U bent ingelogd.";
    exit;
    } else {
    echo "Gebruikersnaam of wachtwoord is onjuist.";
    }
}
?>

<html>
<head>
    <title>Drenthe College docker web server</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <div class="header">
        <h1>Login</h1>
    </div>
    <div class="container">
        <p>Please fill in this form to login to your account.</p> <br>
        <form action='' method="post">
        Username: <br>
        <input type="text" name="username" placeholder="Enter your username" required> <br> <br>
        Password: <br>
        <input type="password" name="password" placeholder="Enter your password" required> <br> <br>
        <input type="submit" value="Login">

        <p>Don't own an account? <a href="index.php">Register here</a></p>

</div>
    </form>
</body>
</html>