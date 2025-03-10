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
    <div class="gridLibrary">
        <div class="gridItem">
        <div id=Library2> <p id="Buttonz" onclick="window.location.href='index.php'">LIBRARY</p> </div>
            <div id=Library2> <p id="Buttonz" onclick="window.location.href='store.php'">STORE</p> </div>
            <div id=add_game2> <p id="Buttonz" onclick="window.location.href='add_game.php'">ADD GAME</p> </div>
            <div id=communityLibrary><p id="Buttonz" onclick="window.location.href='register.php'">REGISTER</p> </div>
            <div id=add_gameLibrary> <p id="Buttonz" onclick="window.location.href='user.php'">ACCOUNT</p> </div>
    </div>

    <?php

        spl_autoload_register(function($class){
            include "classes/" . $class . ".php";
        });

        $db = new Database();

        $gameManager = new GameManager($db);

        if(isset($_POST['submit'])) {

            $gameManager->file_upload($_FILES["fileToUpload"]);
            $gameManager->addGame($_POST, $_FILES["fileToUpload"]['name']);
        }

        $games = $gameManager->getGames();

    ?>

    <form class='addGame' method='POST' enctype="multipart/form-data">
        <div class="addGamediv">
        <label for="title">Title:</label>
        <input type='text' name='title' required><br> 
        
        <label for="genre">Genre:</label>
        <input type='text' name='genre' required> <br> 
        
        <label for="platform">Platform:</label>
        <select id="platform" name="platform">
            <option value="PC_(Steam)">PC (Steam)</option>
            <option value="PS5">Playstation (PS5)</option>
            <option value="PS4">Playstation (PS4)</option>
            <option value="PS3">Playstation (PS3)</option>
            <option value="PS2">Playstation (PS2)</option>
            <option value="PS1">Playstation (PS1)</option>
            <option value="PSvita">Playstation Vita</option>
            <option value="PSP">Playstation Portable (PSP)</option>
            <option value="Nintendo_Switch">Nintendo Switch</option>
            <option value="Mobile">Mobile</option>
            <option value="Xbox_One">Xbox One</option>
            <option value="Xbox_360">Xbox 360</option>
            <option value="Xbox">Xbox</option>
            <option value="Nintendo_3DS">Nintendo 3DS</option>
            <option value="Nintendo_DS">Nintendo DS</option>
            <option value="Nintendo_Wii_U">Nintendo Wii U</option>
            <option value="Nintendo_Wii">Nintendo Wii</option>
            <option value="Nintendo_Gamecube">Nintendo Gamecube</option>
            <option value="Nintendo_64">Nintendo 64</option>
            <option value="Nintendo_SNES">Super Nintendo (SNES)</option>
            <option value="Nintendo_NES">Nintendo Entertainment System (NES)</option>
            <option value="Nintendo">Nintendo</option>
            <option value="SEGA">SEGA</option>
            <option value="Atari">Atari</option>
        </select> <br> 

        
        <label for="release_year">Release Year:</label>
        <input type='date' name='release_year' required> <br> 
        </div>
        <div class="addGamediv2">
        <label for="rating">Rating:</label>
        <input id="range" type="range" name="rating" id="rating" min="1" max="10" step='0.1' value="0" 
            oninput="updateRatingValue(this.value)" required>
        <span id="ratingValue">0.1</span>
        
        <script>
            function updateRatingValue(value) {
                document.getElementById("ratingValue").textContent = value;
            }
        </script> <br> <br>
        
        <label for="developer">Developer:</label>
        <input type='text' name='developer' required> <br> 
        
        <label for="description">Description:</label>
        <input type='text' name='description' required> <br> 
        
        <!-- Hidden file input -->
        <input id="file" type="file" name="fileToUpload" style="display: none;" />

        <!-- Custom label as button -->
        <label for="file" class="custom-file-upload">Upload File</label>


        <input id="submit" type='submit' name='submit'> 
        </div>
    </form>

    <!-- <table border= "1">

        <tr>
            <th>Title</th>
            <th>Genre</th>
            <th>Platform</th>
            <th>Release year</th>
            <th>Rating</th>
            <th>Developer</th>
            <th>Description</th>
            <th>Image</th>
        </tr> -->

        <?php

            // foreach($games as $game) {
            //     echo "<tr>";
            //     echo "<td>" . $game-> getTitle() . "</td>";
            //     echo "<td>" . $game-> getGenre() . "</td>";
            //     echo "<td>" . $game-> getPlatform() . "</td>";
            //     echo "<td>" . $game-> getRelease_year() . "</td>";
            //     echo "<td>" . $game-> getRating() . "</td>";
            //     echo "<td>" . $game-> getDeveloper() . "</td>";
            //     echo "<td>" . $game-> getDescription() . "</td>";
            //     echo "<td>" . $game-> getImage() . "</td>";
            //     echo "</tr>";
            
            // }

        ?>
    <!-- </table> -->


    
</body>
</html>

<script src="background.js"></script>
