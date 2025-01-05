<?php
session_start();
require 'db.php';

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Fetch 30 random questions
$stmt = $pdo->query("SELECT * FROM essay_questions ORDER BY RAND() LIMIT 30");
$questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Modal styles */
        #scoreModal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }

        #scoreModalContent {
            background-color: white;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 400px;
            text-align: center;
            border-radius: 8px;
        }

        #scoreModalContent h2 {
            margin-bottom: 20px;
        }

        #scoreModalContent button {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        #scoreModalContent button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Quiz Time</h2>
        <p id="timer">Time Left: 300 seconds</p>

        <form id="quizForm">
            <?php foreach ($questions as $index => $question): ?>
                <div class="question">
                    <h3><?= htmlspecialchars($question['question']) ?></h3>
                    <input type="radio" name="answer[<?= $question['id'] ?>]" value="1"> <?= htmlspecialchars($question['answer1']) ?><br>
<input type="radio" name="answer[<?= $question['id'] ?>]" value="2"> <?= htmlspecialchars($question['answer2']) ?><br>
<input type="radio" name="answer[<?= $question['id'] ?>]" value="3"> <?= htmlspecialchars($question['answer3']) ?><br>
<input type="radio" name="answer[<?= $question['id'] ?>]" value="4"> <?= htmlspecialchars($question['answer4']) ?><br>

                </div>
            <?php endforeach; ?>
            <button type="button" onclick="submitQuiz()">Submit</button>
        </form>
    </div>

    <!-- Score Modal -->
    <div id="scoreModal">
        <div id="scoreModalContent">
            <h2 id="scoreDisplay"></h2>
            <p>You will be logged out shortly.</p>
        </div>
    </div>

    <script>
        let timeLeft = 300; // 5 minutes in seconds
        let timer;

        function startTimer() {
            timer = setInterval(function () {
                timeLeft--;
                document.getElementById("timer").innerText = "Time Left: " + timeLeft + " seconds";

                if (timeLeft <= 0) {
                    clearInterval(timer);
                    submitQuiz(); // Auto-submit when timer expires
                }
            }, 1000);
        }

        function submitQuiz() {
            const formData = new FormData(document.getElementById("quizForm"));

            fetch('submit_answers.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showScoreModal(data.score);
                    setTimeout(logoutUser, 10000); // Logout after 5 seconds
                } else {
                    alert("An error occurred while submitting the quiz.");
                }
            })
            .catch(error => {
                console.error("Error:", error);
                alert("Failed to submit quiz.");
            });
        }

        function showScoreModal(score) {
            document.getElementById("scoreDisplay").innerText = `Your Total Score: ${score}`;
            document.getElementById("scoreModal").style.display = "block";
        }

        function logoutUser() {
            window.location.href = 'logout.php';
        }

        window.onload = startTimer;
    </script>
</body>
</html>
