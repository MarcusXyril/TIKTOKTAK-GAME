<?php
    session_start();
    if (!isset($_SESSION['username'])) {
        echo json_encode(array('error' => 'User not logged in'));
        exit; 
    }
?>
<script>
    window.onload = function() {
        const welcomeContainer = document.querySelector(".welcome-container");
        const username = "<?php echo isset($_SESSION['username']) ? $_SESSION['username'] : '' ?>";
        if (username) {
            welcomeContainer.innerHTML = username + "!";
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
    <style>

    </style>
</head>

<body>
    <video autoplay="" loop="">
        <source src="tiktoktaklogo1.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    <div id="main">
        <h1>TIC TAC TOE</h1>
        <div class="welcome-container" style="text-align: center;">Welcome!</div>
        <p id="print" style="color: rgb(255, 255, 255);margin-top: 20px;font-size: 30px;font-family: monospace;">A: 1 - O: 0 - Tie: 0</p> <br><br>
        <div class="ui">
            <div class="row" id="board">
                <div class="square" id="square0"></div>
                <div class="square" id="square1"></div>
                <div class="square" id="square2"></div>
                <div class="square" id="square3"></div>
                <div class="square" id="square4"></div>
                <div class="square" id="square5"></div>
                <div class="square" id="square6"></div>
                <div class="square" id="square7"></div>
                <div class="square" id="square8"></div>
                <div class="square" id="square9"></div>
                <div class="square" id="square10"></div>
                <div class="square" id="square11"></div>
                <div class="square" id="square12"></div>
                <div class="square" id="square13"></div>
                <div class="square" id="square14"></div>
                <div class="square" id="square15"></div>
                <div class="square" id="square16"></div>
                <div class="square" id="square17"></div>
                <div class="square" id="square18"></div>
                <div class="square" id="square19"></div>
                <div class="square" id="square20"></div>
                <div class="square" id="square21"></div>
                <div class="square" id="square22"></div>
                <div class="square" id="square23"></div>
                <div class="square" id="square24"></div>
                <div class="square" id="square25"></div>
                <div class="square" id="square26"></div>
                <div class="square" id="square27"></div>
                <div class="square" id="square28"></div>
                <div class="square" id="square29"></div>
            </div>
        </div>
        <button id="but" onclick="restartButton()" style="
        margin-top: 15px;
    ">RESET</button>
        <button class="button back-button" onclick="goHome()">Back</button>
        <div class="popup" id="winPopup">
            <div class="popup-inner">
                <h2 id="popupWinnerText"></h2>
                <button id="playAgainButton" onclick="restartGame()">Play Again</button>
            </div>
        </div>

    </div>

    <script>
        const board = document.getElementById('board');
        const squares = document.getElementsByClassName('square');
        const players = ['X', 'O'];
        let currentPlayer = players[0];
        let difficulty = "Easy"
        let playerScores = {
            'X': 0,
            'O': 0
        };
        const endMessage = document.createElement('h2');
        endMessage.style.fontFamily = 'Sixtyfour';
        endMessage.style.marginTop = '320px';
        endMessage.style.textAlign = 'center';
        endMessage.style.color = '#ffffff';
        board.after(endMessage);

        const winning_combinations = [
            // Horizontal combinations
            [0, 1, 2, 3, 4, 5],
            [6, 7, 8, 9, 10, 11],
            [12, 13, 14, 15, 16, 17],
            [18, 19, 20, 21, 22, 23],
            [24, 25, 26, 27, 28, 29],

            // Vertical Combinations
            [0, 6, 12, 18, 24],
            [1, 7, 13, 19, 25],
            [2, 8, 14, 20, 26],
            [3, 9, 15, 21, 27],
            [4, 10, 16, 22, 28],
            [5, 11, 17, 23, 29],

            // Diagonal Combinations
            // Two
            [1, 6],
            [4, 11],
            [18, 25],
            [23, 28],
            // Three
            [2, 7, 12],
            [3, 10, 17],
            [12, 19, 26],
            [17, 22, 27],
            // Four
            [3, 8, 13, 18],
            [2, 9, 16, 23],
            [6, 13, 20, 27],
            [11, 16, 21, 26],
            // Five
            [0, 7, 14, 21, 28],
            [1, 8, 15, 22, 29],
            [4, 9, 14, 19, 24],
            [5, 10, 15, 20, 25],
        ];

        function updateScores() {
            const printElement = document.getElementById('print');
            printElement.textContent = `X: ${playerScores['X']} - O: ${playerScores['O']}`;
            printElement.style.color = '#ffffff';
            printElement.style.marginTop = '20px';
            printElement.style.fontSize = '30px'; // Set the font size here
        }

        // Display initial scores at the start of the game
        updateScores();

        for (let i = 0; i < squares.length; i++) {
            squares[i].addEventListener('click', () => {
                if (squares[i].textContent !== '' || currentPlayer === 'O') {
                    return;
                }
                squares[i].textContent = currentPlayer;
                if (checkWin(currentPlayer)) {
                    playerScores[currentPlayer]++;
                    updateScores();

                    if (playerScores[currentPlayer] === 5) {
                        openWinPopup(`${currentPlayer} wins the game with 5 points!`);
                        sendResultsToPHP(currentPlayer, difficulty, 5); // This is where you call the function
                    } else {
                        openRoundWinPopup(`${currentPlayer} wins this round!`);
                        setTimeout(resetBoard, 2000);
                    }
                    return;
                }
                if (checkTie()) {
                    openRoundWinPopup(`Game is tied!`);
                    setTimeout(resetBoard, 2000);
                    return;
                }
                currentPlayer = (currentPlayer === players[0]) ? players[1] : players[0];
                if (currentPlayer === 'O') {
                    // AI's turn
                    const difficulty = getSelectedDifficulty();
                    makeMoveAI(difficulty);
                }
            });
        }

        function checkWin(currentPlayer) {
            for (let i = 0; i < winning_combinations.length; i++) {
                const combination = winning_combinations[i];
                let hasWin = true;

                for (let j = 0; j < combination.length; j++) {
                    const squareIndex = combination[j];
                    if (squares[squareIndex].textContent !== currentPlayer) {
                        hasWin = false;
                        break;
                    }
                }

                if (hasWin) {
                    // Add a class to highlight the winning cells
                    for (let k = 0; k < combination.length; k++) {
                        const squareIndex = combination[k];
                        squares[squareIndex].classList.add('highlighted-cell');
                    }

                    return true;
                }
            }

            return false;
        }

        function checkTie() {
            for (let i = 0; i < squares.length; i++) {
                if (squares[i].textContent === '') {
                    return false;
                }
            }
            return true;
        }

        function resetBoard() {
            for (let i = 0; i < squares.length; i++) {
                squares[i].textContent = '';
            }
            currentPlayer = players[0];
        }

        function resetGame() {
            playerScores = {
                'X': 0, 'O': 0
            };
            updateScores();
            resetBoard();
        }

        function makeMoveAI(difficulty) {
            // Call the appropriate AI function based on the selected difficulty
            if (difficulty === 'Easy') {
                startAIGame1();
            } else if (difficulty === 'Difficult') {
                startAIGame2(); // Corrected to call startAIGame2 for Difficult
            } else if (difficulty === 'Expert') {
                startAIGame3();
            }
        }

        function startAIGame1() {
            // Implement AI logic for easy mode
            const emptySquares = getEmptySquares();
            const randomIndex = Math.floor(Math.random() * emptySquares.length);
            const selectedSquare = emptySquares[randomIndex];
            squares[selectedSquare].textContent = currentPlayer;


            if (checkWin(currentPlayer)) {
                playerScores[currentPlayer]++;
                updateScores();
                if (playerScores[currentPlayer] === 5) {
                    openWinPopup(`${currentPlayer} wins the game with 5 points!`);
                    sendResultsToPHP(currentPlayer, getSelectedDifficulty());
                } else {
                    openRoundWinPopup(`${currentPlayer} wins this round!`);
                    setTimeout(resetBoard, 2000);
                }
                return;
            }
            if (checkTie()) {
                openRoundWinPopup(`Game is tied!`);
                setTimeout(resetBoard, 2000);
                return;
            }

            currentPlayer = players[0];
        }


        function getSelectedDifficulty() {
            // Hardcoding the selected difficulty to 'Easy'
            return 'Easy';
        }

        function getEmptySquares() {
            const emptySquares = [];
            for (let i = 0; i < squares.length; i++) {
                if (squares[i].textContent === '') {
                    emptySquares.push(i);
                }
            }
            return emptySquares;
        }

        // Function to open the round win popup
        function openRoundWinPopup(winner) {
            const roundWinPopup = document.getElementById("winPopup");
            const popupWinnerText = document.getElementById("popupWinnerText");
            popupWinnerText.textContent = winner;
            roundWinPopup.style.display = "block";

            // Automatically close the popup after a delay (e.g., 2 seconds)
            setTimeout(() => {
                for (let i = 0; i < squares.length; i++) {
                    squares[i].classList.remove('highlighted-cell');
                }
                roundWinPopup.style.display = "none";
                nextRound();
            }, 2000);
        }

        // Function to start the next round
        function nextRound() {
            // Reset the board for the next round
            resetBoard();



            // Check if any player has reached 5 scores
            if (playerScores['X'] === 5 || playerScores['O'] === 5) {
                // If yes, open the final win popup for the overall winner
                const overallWinner = (playerScores['X'] === 5) ? 'X' : 'O';
                openWinPopup(`${overallWinner} wins the game with 5 points!`);


            } else {
                // If not, continue with the game
                currentPlayer = players[0];
            }
        }

        // Function to open the final win popup
        function openWinPopup(winner) {
            const winPopup = document.getElementById("winPopup");
            const popupWinnerText = document.getElementById("popupWinnerText");
            popupWinnerText.textContent = winner;

            // Display the play again button in the final win popup
            const playAgainButton = document.getElementById("playAgainButton");
            playAgainButton.style.display = "block";

            winPopup.style.display = "block";
        }

        // Function to close the win popup
        function closeWinPopup() {
            const winPopup = document.getElementById("winPopup");
            const playAgainButton = document.getElementById("playAgainButton");

            winPopup.style.display = "none";
            playAgainButton.style.display = "none";
        }

        // Function to restart the game
        function restartGame() {
            closeWinPopup();
            resetGame();
        }

        function goHome() {
            window.location.href = "index.php";
        }

        function sendResultsToPHP(winner, difficulty, score) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'submit_score.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        // Modify this line to send the username of the logged-in user
        const data = `winner=${encodeURIComponent("<?php echo isset($_SESSION['username']) ? $_SESSION['username'] : '' ?>")}&difficulty=${difficulty}&score=${score}`;
        xhr.send(data);
    }

       

    </script>

</body>

</html>
