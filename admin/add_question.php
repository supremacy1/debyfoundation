<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $question = $_POST['question'];
    $answer1 = $_POST['answer1'];
    $answer2 = $_POST['answer2'];
    $answer3 = $_POST['answer3'];
    $answer4 = $_POST['answer4'];
    $correctAnswer = $_POST['correctAnswer'];

    $sql = "INSERT INTO essay_questions (question, answer1, answer2, answer3, answer4, correct_answer, created_at) 
            VALUES (:question, :answer1, :answer2, :answer3, :answer4, :correctAnswer, NOW())";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':question' => $question,
        ':answer1' => $answer1,
        ':answer2' => $answer2,
        ':answer3' => $answer3,
        ':answer4' => $answer4,
        ':correctAnswer' => $correctAnswer,
    ]);

    echo "<script>
        alert('Question added successfully!');
        window.top.location.href = 'admin_dashboard.php';
    </script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Question</title>
    <style>
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-top: 10px;
        }
        input, textarea, select {
            padding: 10px;
            margin-top: 5px;
            font-size: 16px;
        }
        button {
            margin-top: 15px;
            padding: 10px;
            background: #28a745;
            color: white;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h3>Add Essay Question</h3>
    <form method="POST">
        <label>Question</label>
        <textarea name="question" required></textarea>

        <label>Answer 1</label>
        <input type="text" name="answer1" required>

        <label>Answer 2</label>
        <input type="text" name="answer2" required>

        <label>Answer 3</label>
        <input type="text" name="answer3" required>

        <label>Answer 4</label>
        <input type="text" name="answer4" required>

        <label>Correct Answer (1-4)</label>
        <select name="correctAnswer" required>
            <option value="1">Answer 1</option>
            <option value="2">Answer 2</option>
            <option value="3">Answer 3</option>
            <option value="4">Answer 4</option>
        </select>

        <button type="submit">Add Question</button>
    </form>
</body>
</html>
