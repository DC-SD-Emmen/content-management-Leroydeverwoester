<?php 

spl_autoload_register(function ($class) {
    include 'classes/' . $class . '.php';
});
    

class UserManager {

    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }
    
    public function insertUser($username, $email, $password) {

        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $userExists = $stmt->fetchColumn();

        if ($userExists) {
            echo "Username already exists. Please choose a different username.";
            return;
        }

        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $emailExists = $stmt->fetchColumn();

        if ($emailExists) {
            echo "Email already exists. Please choose a different email.";
            return;
        }
        
        try{
            $stmt = $this->conn->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);
            $stmt->execute();
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

    public function connection_user_games($user_id, $game_id) {

        $checkSql = "SELECT COUNT(*) FROM user_games WHERE user_id = :user_id AND game_id = :game_id";
            $checkStmt = $this->conn->prepare($checkSql);
            $checkStmt->bindParam(':user_id', $user_id);
            $checkStmt->bindParam(':game_id', $game_id);
            $checkStmt->execute();

                if ($checkStmt->fetchColumn() > 0) {
                    $message = date('Y-m-d H:i:s') . " - Connection between user and game already exists\n";

                    return false;
                }

        $checkStmt = $this->conn->prepare($checkSql);


            $sql= "INSERT INTO user_games (user_id, game_id) VALUES (:user_id, :game_id)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':game_id', $game_id);
            $stmt->execute();
}

public function connection_bought_games($user_id, $game_id) {

    $checkSql = "SELECT COUNT(*) FROM bought_games WHERE user_id = :user_id AND game_id = :game_id";
        $checkStmt = $this->conn->prepare($checkSql);
        $checkStmt->bindParam(':user_id', $user_id);
        $checkStmt->bindParam(':game_id', $game_id);
        $checkStmt->execute();

            if ($checkStmt->fetchColumn() > 0) {
                $message = date('Y-m-d H:i:s') . " - Connection between user and game already exists\n";

                return false;
            }

    $checkStmt = $this->conn->prepare($checkSql);


        $sql= "INSERT INTO bought_games (user_id, game_id) VALUES (:user_id, :game_id)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':game_id', $game_id);
        $stmt->execute();
    }

    public function removeFromWishlist($user_id, $game_id) {
        try {
            $sql = "DELETE FROM user_games WHERE user_id = :user_id AND game_id = :game_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':game_id', $game_id);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            exit();
        }
    }

    public function delete($user_id, $game_id) {
        try {
            $sql = "DELETE FROM bought_games WHERE user_id = :user_id AND game_id = :game_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':game_id', $game_id);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            exit();
        }
    }

    public function deleteAccount($user_id) {
        try {
            // Begin transaction
            $this->conn->beginTransaction();

            // Delete from bought_games
            $sql = "DELETE FROM bought_games WHERE user_id = :user_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();

            // Delete from user_games
            $sql = "DELETE FROM user_games WHERE user_id = :user_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();

            // Delete from users
            $sql = "DELETE FROM users WHERE id = :user_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();

            // Commit transaction
            $this->conn->commit();
        } catch (PDOException $e) {
            // Rollback transaction if something failed
            $this->conn->rollBack();
            echo "Error: " . $e->getMessage();
            exit();
        }
    }
   
public function changeUsername($user_id, $new_username) {
    try {
        // Check if the new username already exists
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM users WHERE username = :new_username");
        $stmt->bindParam(':new_username', $new_username);
        $stmt->execute();
        $usernameExists = $stmt->fetchColumn();

        if ($usernameExists) {
            echo "Username already exists. Please choose a different username.";
            return false;
        }

        // Update the username
        $sql = "UPDATE users SET username = :new_username WHERE id = :user_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':new_username', $new_username);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();

        return true;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit();
    }
}


}
?>