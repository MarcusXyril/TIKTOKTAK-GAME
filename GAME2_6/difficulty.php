<?php
    session_start();
    if(!isset($_SESSION["user_login"])){
        header("Location: login.php");
    }
?>
<script>
    window.onload = function() {
        const welcomeContainer = document.querySelector(".welcome-container");
        const username = "<?php echo isset($_SESSION['username']) ? $_SESSION['username'] : '' ?>";
        if (username) {
            welcomeContainer.innerHTML = "Welcome, " + username + "!";
        }
    };
</script>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style1.css">
    <script src="script.js"></script>
    
    <audio id="gameSound" src="cartoon-jump-6462.mp3" preload="auto"></audio>

    <title>Tic-Tac-Toe</title>
    <video autoplay="" loop="">
    <source src="tiktoktaklogo1.mp4" type="video/mp4">
    Your browser does not support the video tag.
</video>
</head>
<div class="header">
    <header style="color: white;">
        <section class="title-header">
            <h1 class="h1" style="font-family: ;color: white;"><img class="logoheader" src="tiktoktaklogo.jpg" style="">Tik<span style="color:black;font-style: italic;">Tok</span>Tak</h1>
        </section>
        <div class="welcome-container" style="">Welcome, andrei!</div>
        <div>

        </div>
        <div style="text-align: end;margin-right: 25px;margin-top: -3px;" class="">
                <a href="logout.php" class="logout">Logout</a>
            </div>
</header>
</div>
<body>


<script src="hometictactoe.js"></script>
<!-- AI Difficulty Popup -->
<div id="aiDifficultyPopup" class="container screen" style="display: block;">
  <h1>Select AI Difficulty:</h1>
  <div>
    <button class="button easy-button" onclick="easy()">EASY</button>
    <button class="button difficult-button" onclick="hard()">HARD</button>
    <button class="button expert-button" onclick="expert()">EXPERT</button>
</div>
<button class="button back-button" onclick="goHome()" style="
    width: 140px;
    height: 67px;
">Home</button>
<div id="footer"> Catu, Andrei - Constantino, Luis Emmanuel - Genato, Michael - Guinto, Julianne - Lavenco, Marcus </div>

</div>
</body>
</html>
