<?php
session_start();
require 'db.php';

// Define the session timeout duration (15 minutes)
define('SESSION_TIMEOUT', 15 * 60); // 15 minutes in seconds

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Check if session has expired
if (isset($_SESSION['login_time']) && (time() - $_SESSION['login_time']) > SESSION_TIMEOUT) {
    // Session has expired, log the user out
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit;
}

// Fetch random question
try {
    $stmt = $pdo->query("SELECT * FROM questions ORDER BY RAND() LIMIT 1");
    $randomQuestion = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching question: " . $e->getMessage();
    $randomQuestion = null;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
</head>
<body>
    <h1>Welcome, <?= htmlspecialchars($_SESSION['email']) ?></h1>

    <!-- Display Random Question -->
    <?php if ($randomQuestion): ?>
        <h3>Here is your question:</h3>
        <p><?= htmlspecialchars($randomQuestion['question']) ?></p>
        <form method="POST" action="submit_answer.php">
            <input type="radio" name="answer" value="A" required> <?= htmlspecialchars($randomQuestion['answer_a']) ?><br>
            <input type="radio" name="answer" value="B" required> <?= htmlspecialchars($randomQuestion['answer_b']) ?><br>
            <input type="radio" name="answer" value="C" required> <?= htmlspecialchars($randomQuestion['answer_c']) ?><br>
            <input type="radio" name="answer" value="D" required> <?= htmlspecialchars($randomQuestion['answer_d']) ?><br>
            <input type="hidden" name="question_id" value="<?= $randomQuestion['id'] ?>">
            <button type="submit">Submit Answer</button>
        </form>
    <?php else: ?>
        <p>No questions available at the moment.</p>
    <?php endif; ?>
</body>
</html>
