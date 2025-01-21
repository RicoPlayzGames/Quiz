<?php
require 'config.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $quizName = $_POST['quiz_name'];
    $questions = $_POST['questions'];

    if (empty($quizName) || empty($questions)) {
        $error = 'Vul de naam van de quiz en minstens één vraag in.';
    } else {
        try {
            $pdo->beginTransaction();

            // Add the quiz
            $stmt = $pdo->prepare("INSERT INTO quizzes (name) VALUES (:name)");
            $stmt->execute(['name' => $quizName]);
            $quizId = $pdo->lastInsertId();

            // Add questions and answers
            foreach ($questions as $question) {
                $stmt = $pdo->prepare("INSERT INTO questions (question, quiz_id) VALUES (:question, :quiz_id)");
                $stmt->execute([
                    'question' => $question['text'],
                    'quiz_id' => $quizId
                ]);
                $questionId = $pdo->lastInsertId();

                foreach ($question['answers'] as $answer) {
                    $stmt = $pdo->prepare("INSERT INTO answers (question_id, answer, is_correct) VALUES (:question_id, :answer, :is_correct)");
                    $stmt->execute([
                        'question_id' => $questionId,
                        'answer' => $answer['text'],
                        'is_correct' => isset($answer['is_correct']) ? 1 : 0
                    ]);
                }
            }

            $pdo->commit();
            $success = 'Quiz succesvol opgeslagen!';
        } catch (Exception $e) {
            $pdo->rollBack();
            $error = 'Fout bij het opslaan: ' . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Aanmaken</title>
    <script>
        let questionIndex = 0;

        function addQuestion() {
            questionIndex++;
            const questionsContainer = document.getElementById('questions-container');
            const questionHtml = `
                <div class="question-block">
                    <label>Vraag:</label><br>
                    <input type="text" name="questions[${questionIndex}][text]" required><br><br>

                    <div class="answers-container">
                        <label>Antwoorden:</label><br>
                        <input type="text" name="questions[${questionIndex}][answers][0][text]" required>
                        <label>
                            <input type="checkbox" name="questions[${questionIndex}][answers][0][is_correct]">
                            Correct antwoord
                        </label><br>
                    </div>
                    <button type="button" onclick="addAnswer(this)">Antwoord toevoegen</button>
                    <hr>
                </div>
            `;
            questionsContainer.insertAdjacentHTML('beforeend', questionHtml);
        }

        function addAnswer(button) {
            const answersContainer = button.previousElementSibling;
            const answerCount = answersContainer.querySelectorAll('input[type="text"]').length;
            const questionIndex = button.parentElement.querySelector('input[name^="questions"]').name.match(/\d+/)[0];
            const answerHtml = `
                <input type="text" name="questions[${questionIndex}][answers][${answerCount}][text]" required>
                <label>
                    <input type="checkbox" name="questions[${questionIndex}][answers][${answerCount}][is_correct]">
                    Correct antwoord
                </label><br>
            `;
            answersContainer.insertAdjacentHTML('beforeend', answerHtml);
        }
    </script>
</head>
<body>
    <h1>Quiz Aanmaken</h1>
    <?php if ($error): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php elseif ($success): ?>
        <p style="color: green;"><?php echo htmlspecialchars($success); ?></p>
    <?php endif; ?>

    <form method="POST" action="import_quiz.php">
    <label for="question">Vraag:</label><br>
    <input type="text" id="question" name="question" required><br><br>

    <label for="answer1">Antwoord 1:</label><br>
    <input type="text" id="answer1" name="answers[]" required><br><br>

    <label for="answer2">Antwoord 2:</label><br>
    <input type="text" id="answer2" name="answers[]" required><br><br>

    <label for="answer3">Antwoord 3:</label><br>
    <input type="text" id="answer3" name="answers[]" required><br><br>

    <label for="answer4">Antwoord 4:</label><br>
    <input type="text" id="answer4" name="answers[]" required><br><br>

    <label for="correct">Correct Antwoord (1-4):</label><br>
    <input type="number" id="correct" name="correct" min="1" max="4" required><br><br>

    <button type="submit">Opslaan</button>
</form>

</body>
</html>
