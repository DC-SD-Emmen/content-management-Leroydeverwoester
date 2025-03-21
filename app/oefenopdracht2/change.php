<?php
    session_start();

    spl_autoload_register(function($class){
        include "classes/" . $class . ".php";
    });
            
    if (!isset($_SESSION['username'])) {
        header("Location: login.php");
        exit;
        }

    $database = new Database();
    $userManager = new UserManager($database->getConnection());
    $user = $userManager->getUser($_SESSION['username']);

    if ($user === false) {
        echo "User not found!";
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $newUsername = htmlspecialchars($_POST['username'] ?? '');
        $newEmail = htmlspecialchars($_POST['email'] ?? '');
        $newPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $stmt = $database->getConnection()->prepare("SELECT COUNT(*) FROM users WHERE (username = :username OR email = :email) AND username != :currentUsername");
        $stmt->bindParam(':username', $newUsername);
        $stmt->bindParam(':email', $newEmail);
        $currentUsername = $_SESSION['username'];
        $stmt->bindParam(':currentUsername', $currentUsername);
        $stmt->execute();
        $count = $stmt->fetchColumn();
    
        if ($count > 0) {
            $_SESSION['error'] = "Username or email already exists!";
            header("Location: change.php");
            exit;
        }
        
        $currentPassword = $_POST['current_password'] ?? '';
        if (!$user || !isset($user['password']) || !password_verify($currentPassword, $user['password'])) {
            $_SESSION['error'] = "Current password is incorrect!";
            header("Location: change.php");
            exit;
        }

        $_SESSION['username'] = $newUsername;

        $stmt = $database->getConnection()->prepare("UPDATE users SET username = :username, email = :email, password = :password WHERE username = :currentUsername");
        $stmt->bindParam(':username', $newUsername);
        $stmt->bindParam(':email', $newEmail);
        $stmt->bindParam(':password', $newPassword);
        $stmt->bindParam(':currentUsername', $currentUsername);
        $stmt->execute();

        
        $user = $userManager->getUser($newUsername);

        $_SESSION['success'] = "Account details updated successfully!";
            header("Location: change.php");
            exit;
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

    <div class="gridItem">

        <div id=communityLibrary> <p id="Buttonz" onclick="window.location.href='index.php'">LIBRARY</p> </div>
        <div id=storeLibrary> <p id="Buttonz" onclick="window.location.href='store.php'">STORE</p> </div>

            <?php if (isset($_SESSION['username']) && $_SESSION['username'] === 'Admin'): ?>
                <div id=add_gameLibrary> <p id="Buttonz" onclick="window.location.href='add_game.php'">ADD GAME</p> </div>
            <?php endif; ?>

        <div id=add_gameLibrary> <p id="Buttonz" onclick="window.location.href='login.php'">LOGIN</p> </div>
        <div id=libraryLibrary> <p id="Buttonz" onclick="window.location.href='user.php'">ACCOUNT</p> </div>
    </div>

    <div class="container">
        <?php if (isset($_SESSION['error'])): ?>
            <p style="color: red;"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
            <p style="color: green;"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></p>
        <?php endif; ?>


        <form action="change.php" method="POST">
            Change Username (optional): <br>
            <input type="text" name="username" value="<?php echo $user['username']; ?>" required> <br>
            Change E-Mail (optional): <br>
            <input type="email" name="email" value="<?php echo $user['email']; ?>" required> <br>
            Enter your password: <br>
            <input type="password" name="current_password" placeholder="Enter your current password" required> <br>
            <input type="password" name="password" placeholder="Enter your (new) password" required> <br>
            <input type="submit" value="Update"> <br>
            <a class="deleteAccount" href="register.php?action=deleteAccount" onclick="return confirm('Are you sure you want to delete your account?');">Delete Account</a>
        </form>
    </div>
</body>
</html>

<script src="background.js"></script>

