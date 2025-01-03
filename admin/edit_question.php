<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM essay_questions WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
    $question = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $questionText = $_POST['question'];
    $answer1 = $_POST['answer1'];
    $answer2 = $_POST['answer2'];
    $answer3 = $_POST['answer3'];
    $answer4 = $_POST['answer4'];
    $correctAnswer = $_POST['correctAnswer'];

    $sql = "UPDATE essay_questions 
            SET question = :question, answer1 = :answer1, answer2 = :answer2, 
                answer3 = :answer3, answer4 = :answer4, correct_answer = :correctAnswer 
            WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':question' => $questionText,
        ':answer1' => $answer1,
        ':answer2' => $answer2,
        ':answer3' => $answer3,
        ':answer4' => $answer4,
        ':correctAnswer' => $correctAnswer,
        ':id' => $id,
    ]);

    header('Location: admin_dashboard.php');
    exit();
}
?>
