<?php
$questions = [
    [
        "question" => "Wat is de hoofdstad van Nederland?",
        "answers" => ["Amsterdam", "Rotterdam", "Den Haag", "Utrecht"],
        "correct" => 0 
    ],
    [
        "question" => "Welke planeet staat het dichtst bij de zon?",
        "answers" => ["Mars", "Venus", "Aarde", "Mercurius"],
        "correct" => 3
    ],
    [
        "question" => "Hoeveel minuten zitten er in een uur?",
        "answers" => ["50", "60", "70", "80"],
        "correct" => 1
    ],
];


session_start();


if (isset($_GET['reset'])) {
    session_destroy();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}


if (!isset($_SESSION['currentQuestionIndex'])) {
    $_SESSION['currentQuestionIndex'] = 0; 
    $_SESSION['correctAnswers'] = 0;      
    $_SESSION['totalQuestions'] = count($questions); 
}

$currentQuestionIndex = $_SESSION['currentQuestionIndex'];


if ($currentQuestionIndex >= $_SESSION['totalQuestions']) {
    $quizFinished = true;
} else {
    $quizFinished = false;
    $currentQuestion = $questions[$currentQuestionIndex];
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$quizFinished) {
    $selectedAnswer = intval($_POST['answer']);
    if ($selectedAnswer === $currentQuestion['correct']) {
        $_SESSION['correctAnswers']++; 
    }

    
    $_SESSION['currentQuestionIndex']++;
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quizpagina</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 20px;
        }
        h1 {
            color: #333;
        }
        .question {
            margin: 20px 0;
            font-size: 1.5rem;
        }
        .answers button {
            display: block;
            margin: 10px auto;
            padding: 10px 20px;
            font-size: 1rem;
            cursor: pointer;
            border: 1px solid #333;
            background-color: #f4f4f4;
        }
        .answers button:hover {
            background-color: #ddd;
        }
        .result {
            font-size: 1.2rem;
            margin-top: 20px;
        }
        .result.correct {
            color: green;
        }
        .result.incorrect {
            color: red;
        }
        .reset-button {
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 1rem;
            background-color: #333;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        .reset-button:hover {
            background-color: #555;
        }
    </style>
</head>
<body>
    <h1>Weet & Win</h1>

    <?php if ($quizFinished): ?>
        <!-- Resultatenscherm -->
        <div class="result">
            <p>Je hebt de quiz voltooid!</p>
            <p>Je hebt <strong><?php echo $_SESSION['correctAnswers']; ?></strong> van de <strong><?php echo $_SESSION['totalQuestions']; ?></strong> vragen goed beantwoord.</p>
        </div>
        <form method="get">
            <button class="reset-button" name="reset">Opnieuw starten</button>
        </form>
    <?php else: ?>
        <!-- Vraag tonen -->
        <div class="question">
            <p><?php echo $currentQuestion["question"]; ?></p>
        </div>

        <!-- Antwoorden tonen -->
        <form method="POST" class="answers">
            <?php foreach ($currentQuestion["answers"] as $index => $answer): ?>
                <button type="submit" name="answer" value="<?php echo $index; ?>">
                    <?php echo $answer; ?>
                </button>
            <?php endforeach; ?>
        </form>
    <?php endif; ?>
</body>
</html>
