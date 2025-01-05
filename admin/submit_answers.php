<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['success' => false, 'message' => 'User not logged in.']);
        exit;
    }

    // Fetch the user's answers from POST data
    $answers = $_POST['answer'] ?? [];
    $score = 0;

    foreach ($answers as $questionId => $userAnswer) {
        // Fetch the correct answer for the current question
        $stmt = $pdo->prepare("SELECT correct_answer FROM essay_questions WHERE id = :id");
        $stmt->execute(['id' => $questionId]);
        $correctAnswer = $stmt->fetchColumn();

        // Compare the user's answer with the correct answer
        if ($userAnswer == $correctAnswer) { // Use `==` because `userAnswer` is a string and `correct_answer` is an integer
            $score++;
        }
    }

    // Save the score in the database and mark the user as completed
    $stmt = $pdo->prepare("INSERT INTO scores (user_id, score) VALUES (:user_id, :score)");
    $stmt->execute(['user_id' => $_SESSION['user_id'], 'score' => $score]);

    $stmt = $pdo->prepare("UPDATE users SET has_completed_quiz = 1 WHERE id = :user_id");
    $stmt->execute(['user_id' => $_SESSION['user_id']]);

    echo json_encode(['success' => true, 'score' => $score]);
}
