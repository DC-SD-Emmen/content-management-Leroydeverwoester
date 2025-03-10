<?php

class UserManager {

    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }
    
    public function insertUser($username, $email, $password) {

        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM users WHERE username = :username");
        $stmt->bindParam(':username', $_POST['username']);
        $stmt->execute();
        $userExists = $stmt->fetchColumn();

        if ($userExists) {
            header("Location: register.php");
            echo "Username already exists. Please choose a different username.";
            exit();
        }

        try{
            $stmt = $this->conn->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);
            $stmt->execute();
            echo "Registration success!";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            exit();
        }
    }

    public function getUser($username) {
        
        try{
            $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = :username");
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            $user = $stmt->fetch();
            return $user;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            exit();
        }
    }

}

?>