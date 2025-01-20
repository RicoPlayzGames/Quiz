<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $question = $_POST['question'];
    $answers = $_POST['answers'];
    $correct = $_POST['correct'];

    $stmt = $pdo->prepare("
        INSERT INTO questions (question, correct) 
        VALUES (:question, :correct)
    ");
    $stmt->execute(['question' => $question, 'correct' => $correct]);
    $question_id = $pdo->lastInsertId();

    foreach ($answers as $index => $answer) {
        $stmt = $pdo->prepare("
            INSERT INTO answers (question_id, answer_text, is_correct) 
            VALUES (:question_id, :answer_text, :is_correct)
        ");
        $stmt->execute([
            'question_id' => $question_id,
            'answer_text' => $answer,
            'is_correct' => ($index + 1 == $correct) ? 1 : 0
        ]);
    }

    echo "Vraag en antwoorden zijn succesvol opgeslagen!";
}
?>