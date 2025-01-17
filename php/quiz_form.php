<?php
require 'config.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $quizName = trim($_POST['quiz_name']);
    $questions = $_POST['questions'];

    if (empty($quizName) || empty($questions)) {
        $error = 'Vul de naam van de quiz en minstens één vraag in.';
    } else {
        try {
            $pdo->beginTransaction();

            // Voeg de quiz toe
            $stmt = $pdo->prepare("INSERT INTO quizzes (name) VALUES (:name)");
            $stmt->execute(['quiz_id' => $quizName]);
            $quizId = $pdo->lastInsertId();

            // Voeg vragen toe
            foreach ($questions as $qIndex => $question) {
                $stmt = $pdo->prepare("INSERT INTO questions (quiz_id, question_text) VALUES (:quiz_id, :text)");
                $stmt->execute(['quiz_id' => $quizId, 'text' => $question['text']]);
                $questionId = $pdo->lastInsertId();

                // Voeg antwoorden toe
                foreach ($question['answers'] as $aIndex => $answer) {
                    $stmt = $pdo->prepare("INSERT INTO answers (question_id, answer_text, is_correct) VALUES (:question_id, :text, :correct)");
                    $stmt->execute([
                        'question_id' => $questionId,
                        'text' => $answer['text'],
                        'correct' => $aIndex == $question['correct'] ? 1 : 0
                    ]);
                }
            }

            $pdo->commit();
            $success = 'Quiz succesvol aangemaakt!';
        } catch (Exception $e) {
            $pdo->rollBack();
            $error = 'Er is een fout opgetreden: ' . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Quiz Aanmaken</title>
</head>
<body>
    <h1>Quiz Aanmaken</h1>
    <?php if ($error): ?>
        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php elseif ($success): ?>
        <p style="color: green;"><?= htmlspecialchars($success) ?></p>
    <?php endif; ?>

    <form method="POST">
        <label>Naam van de quiz:</label>
        <input type="text" name="quiz_name" required><br><br>

        <div id="questions-container">
            <div class="question">
                <textarea name="questions[0][text]" placeholder="Vraag 1" required></textarea>
                <div>
                    <input type="text" name="questions[0][answers][0][text]" placeholder="Antwoord 1" required>
                    <input type="radio" name="questions[0][correct]" value="0" required> Correct
                </div>
                <div>
                    <input type="text" name="questions[0][answers][1][text]" placeholder="Antwoord 2" required>
                    <input type="radio" name="questions[0][correct]" value="1"> Correct
                </div>
            </div>
        </div>

        <button type="button" id="add-question">Vraag toevoegen</button>
        <button type="submit">Quiz opslaan</button>
    </form>

    <script>
        let questionIndex = 1;
        document.getElementById('add-question').addEventListener('click', () => {
            const container = document.getElementById('questions-container');
            const div = document.createElement('div');
            div.className = 'question';
            div.innerHTML = `
                <textarea name="questions[${questionIndex}][text]" placeholder="Vraag ${questionIndex + 1}" required></textarea>
                <div>
                    <input type="text" name="questions[${questionIndex}][answers][0][text]" placeholder="Antwoord 1" required>
                    <input type="radio" name="questions[${questionIndex}][correct]" value="0" required> Correct
                </div>
                <div>
                    <input type="text" name="questions[${questionIndex}][answers][1][text]" placeholder="Antwoord 2" required>
                    <input type="radio" name="questions[${questionIndex}][correct]" value="1"> Correct
                </div>
            `;
            container.appendChild(div);
            questionIndex++;
        });
    </script>
</body>
</html>
