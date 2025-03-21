<?php 

    spl_autoload_register(function($class){
        include "classes/" . $class . ".php";
    });

    //zet database klaar en maak een connectie
    class GameManager {

        private $conn;

        public function __construct(Database $db) {
            $this->conn = $db->getConnection();
        }

        public function getGame($id) {
            $stmt = $this->conn->prepare("SELECT * FROM games WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Game');
            return $stmt->fetch();
        }

        public function remove($id) {
            // First delete related rows in user_games table
            $stmt = $this->conn->prepare("DELETE FROM user_games WHERE game_id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            // Then delete related rows in bought_games table
            $stmt = $this->conn->prepare("DELETE FROM bought_games WHERE game_id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            // Then delete the game
            $stmt = $this->conn->prepare("DELETE FROM games WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        }


        public function addGame($data, $image) {
            $title = isset($data['title']) ? htmlspecialchars($data['title']) : '';
            $genre = isset($data['genre']) ? htmlspecialchars($data['genre']) : '';
            $platform = isset($data['platform']) ? $data['platform'] : '';
            $release_year = isset($data['release_year']) ? $data['release_year'] : '';
            $rating = isset($data['rating']) ? $data['rating'] : '';
            $developer = isset($data['developer']) ? htmlspecialchars($data['developer']) : '';
            $description = isset($data['description']) ? htmlspecialchars($data['description']) : '';
            
            //regex statement wordt aangemaakt / klaargezet
            $titleRegex = '/^[\w\s,.-:®™()]+$/';
            $genreRegex = '/^[\w\s,.-:®™]+$/';
            $developerRegex = '/^[\w\s,.-:()]+$/';
        
            echo"<br>";
        
            //regex controle wordt uitgevoerd
            if(!preg_match($titleRegex, $title)) {
                echo "Title is invalid.";
            }else if(!preg_match($genreRegex, $genre)) {
                echo "Genre is invalid.";
            } else if(!preg_match($developerRegex, $developer)) {
                echo "Developer is invalid.";
            } else {

                try {

                    //insert sql statement
                    $sql = "INSERT INTO games (title, genre, platform, release_year, rating, developer, description, image)
                            VALUES (:title, :genre, :platform, :release_year, :rating, :developer, :description, :image)";

                    //statement klaarzetten
                    $stmt = $this->conn->prepare($sql);

                    //binden doen we om SQL injectie attack the voorkomen
                    //binden van de data aan de VALUES
                    $stmt->bindParam(':title', $title);
                    $stmt->bindParam(':genre', $genre);
                    $stmt->bindParam(':platform', $platform);
                    $stmt->bindParam(':release_year', $release_year);
                    $stmt->bindParam(':rating', $rating);
                    $stmt->bindParam(':developer', $developer);
                    $stmt->bindParam(':description', $description);
                    $stmt->bindParam(':image', $image);
                    
                    //statement uitvoeren (execute) en melding geven of het goed is gegaan
                    $stmt->execute();
                    echo "data inserted successfully<br><br>";
                    } 
                    //melding als het niet goed ging 
                    catch (PDOException $e) {
                        echo "Insert data failed: " . $e->getMessage();
                        echo "<br><br>";
                    }
                }
            }
        
            public function searchGames($keyword) {
                $keyword = "%" . htmlspecialchars($keyword) . "%";
                $stmt = $this->conn->prepare("SELECT * FROM games WHERE title LIKE :keyword OR genre LIKE :keyword OR developer LIKE :keyword");
                $stmt->bindParam(':keyword', $keyword);
                $stmt->execute();
                $stmt->setFetchMode(PDO::FETCH_CLASS, 'Game');
                return $stmt->fetchAll();
            }

        //haal data van alle games terug uit de database
        public function getGames($game_id = null) {
            $db = new Database();
            $game_data_list = $db->getData($game_id);

            $games = [];
            foreach ($game_data_list as $game_data) {
                
                $game = new Game();
                $game->setId($game_data['id']);
                $game->setTitle($game_data['title']);
                $game->setGenre($game_data['genre']);
                $game->setPlatform($game_data['platform']);
                $game->setDeveloper($game_data['developer']);
                $game->setRelease_year($game_data['release_year']);
                $game->setRating($game_data['rating']);
                $game->setDescription($game_data['description']);
                $game->setImage($game_data['image']);

                $games[] = $game;

            }
            return $games;

        }

        //stuur de file naar uploads folder
        public function file_upload($file) {

            $target_dir = "uploads/";
            $target_file = $target_dir . basename($file["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        // Check if image file is an actual image or a fake image
            $check = getimagesize($file["tmp_name"]);
            if($check !== false) {
                echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                echo "File is not an image.";
                $uploadOk = 0;
            }

        // Check if file already exists
            if (file_exists($target_file)) {
                echo "Sorry, file already exists.";
                $uploadOk = 0;
            }

        // Check file size
            if ($file["size"] > 50000000) {
                echo "Sorry, your file is too large.";
                $uploadOk = 0;
            }

        // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "webp" ) {
                echo "Sorry, only JPG, JPEG, PNG & WEBP files are allowed.";
                $uploadOk = 0;
            }

        // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                echo "Sorry, your file was not uploaded.";
            
        // if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($file["tmp_name"], $target_file)) {
                    echo "The file ". htmlspecialchars( basename( $file["name"])). " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
            }
        }


        function get_data_by_id($id) {
            try {
                // SQL-query aanpassen om een specifieke game te selecteren
                $stmt = $this->conn->prepare("SELECT * FROM game WHERE id = :id");
                $stmt->bindParam(':id', $id, PDO::PARAM_INT); // Bind het ID aan de query
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    $row = $stmt->fetch(PDO::FETCH_ASSOC); // Haal één enkele rij op

                    // Maak een nieuw game-object
                    $game = new Game();
                    $game->setTitle($row["title"]);
                    $game->setImage($row["image"]);
                    $game->setGenre($row["genre"]);
                    $game->setPlatform($row["platform"]);
                    $game->setRelease_year($row["release_year"]);
                    $game->setRating($row["rating"]);
                    $game->setDescription($row["description"]);
                    $game->setDeveloper($row["developer"]);

                    // Haal data op
                    $titel = $game->getTitle();
                    $afbeeldingPath = $game->getImage();
                    $genre = $game->getGenre();
                    $platform = $game->getPlatform();
                    $Release_year = $game->getRelease_year();
                    $rating = $game->getRating();
                    $description = $game->getDescription();
                    $developer = $game->getDeveloper();
        // Toon de gegevens van de game
                    echo '<div>';
                    echo '<img class="normalImage" src="uploads/' . htmlspecialchars($afbeeldingPath) . '">';
                    echo '<h1>' . htmlspecialchars($titel) . '</h1>';
                    echo '<p>Genre: ' . htmlspecialchars($genre) . '</p>';
                    echo '<p>Platform: ' . htmlspecialchars($platform) . '</p>';
                    echo '<p>Release Year: ' . htmlspecialchars($Release_year) . '</p>';
                    echo '<p>Rating: ' . htmlspecialchars($rating) . '</p>';
                    echo '<p>Description: ' . htmlspecialchars($description) . '</p>';
                    echo '<p>Developer: ' . htmlspecialchars($developer) . '</p>';
                    echo '</div>';
                } else {
                    echo "Geen resultaten gevonden.";
                }
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }


    public function searchBoughtGames($searchTerm, $user_id) {
        $query = "
            SELECT games.title, games.image, games.id
            FROM games
            INNER JOIN bought_games ON games.id = bought_games.game_id
            WHERE bought_games.user_id = :user_id AND games.title LIKE :searchTerm;
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindValue(':searchTerm', '%' . $searchTerm . '%');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }




    }
?>

