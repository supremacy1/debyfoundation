<?php
require 'db.php';

// Fetch registered users
try {
    $sql = "SELECT * FROM users ORDER BY registration_date DESC";
    $stmt = $pdo->query($sql);
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching users: " . $e->getMessage();
    $users = [];
}

// Fetch questions
try {
    $sqlQuestions = "SELECT * FROM essay_questions ORDER BY created_at DESC";
    $stmtQuestions = $pdo->query($sqlQuestions);
    $questions = $stmtQuestions->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching questions: " . $e->getMessage();
    $questions = [];
}
// Fetch questions

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        /* Styles here */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 900px;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .btn {
            padding: 10px 15px;
            margin: 10px 0;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        .btn-add {
            background-color: #28a745;
        }
        .btn-edit {
            background-color: #ffc107;
        }
        .btn-delete {
            background-color: #dc3545;
        }
        /* Popup styles */
        .popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1000;
            width: 90%;
            max-width: 500px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.25);
            padding: 20px;
        }
        .popup.active {
            display: block;
        }
        .popup-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .popup-header h3 {
            margin: 0;
        }
        .popup-close {
            cursor: pointer;
            color: red;
            font-size: 18px;
            font-weight: bold;
            background: none;
            border: none;
        }
        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }
        .overlay.active {
            display: block;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Admin Dashboard</h2>

        <!-- Add Question Button -->
        <button class="btn btn-add" id="addQuestionBtn">Add Question</button>

        <!-- Popup and Overlay -->
        <div class="overlay" id="popupOverlay"></div>
        <div class="popup" id="popupForm">
            <div class="popup-header">
                <h3>Add Question</h3>
                <button class="popup-close" id="closePopupBtn">&times;</button>
            </div>
            <iframe src="add_question.php" frameborder="0" style="width: 100%; height: 400px;"></iframe>
        </div>

        <!-- Registered Users Table -->
        <h3>Registered Users</h3>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Registered On</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $index => $user): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= htmlspecialchars($user['first_name'] . " " . $user['last_name']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td><?= htmlspecialchars($user['phone']) ?></td>
                        <td><?= htmlspecialchars($user['address']) ?></td>
                        <td><?= htmlspecialchars($user['registration_date']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Questions Table -->
        <h3>Questions</h3>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Question</th>
                    <th>Answer A</th>
                    <th>Answer B</th>
                    <th>Answer C</th>
                    <th>Answer D</th>
                    <th>Correct Answer</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($questions as $index => $question): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= htmlspecialchars($question['question']) ?></td>
                        <td><?= htmlspecialchars($question['answer1']) ?></td>
                        <td><?= htmlspecialchars($question['answer2']) ?></td>
                        <td><?= htmlspecialchars($question['answer3']) ?></td>
                        <td><?= htmlspecialchars($question['answer4']) ?></td>
                        <td><?= htmlspecialchars($question['correct_answer']) ?></td>
                        <td>
                            <a href="edit_question.php?id=<?= $question['id'] ?>" class="btn btn-edit">Edit</a>
                            <a href="delete_question.php?id=<?= $question['id'] ?>" class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this question?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <h3>Registered Users</h3>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Registered On</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $index => $user): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= htmlspecialchars($user['first_name'] . " " . $user['last_name']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td><?= htmlspecialchars($user['phone']) ?></td>
                        <td><?= htmlspecialchars($user['address']) ?></td>
                        <td><?= htmlspecialchars($user['registration_date']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>

    <script>
        // JavaScript for Popup
        const addQuestionBtn = document.getElementById('addQuestionBtn');
        const popupOverlay = document.getElementById('popupOverlay');
        const popupForm = document.getElementById('popupForm');
        const closePopupBtn = document.getElementById('closePopupBtn');

        addQuestionBtn.addEventListener('click', () => {
            popupOverlay.classList.add('active');
            popupForm.classList.add('active');
        });

        closePopupBtn.addEventListener('click', () => {
            popupOverlay.classList.remove('active');
            popupForm.classList.remove('active');
        });

        popupOverlay.addEventListener('click', () => {
            popupOverlay.classList.remove('active');
            popupForm.classList.remove('active');
        });
    </script>
</body>
</html>
