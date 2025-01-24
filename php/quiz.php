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
    [
        "question" => "Hoeveel seconden zitten er in een minuut?",
        "answers" => ["30", "60", "90", "120"],
        "correct" => 1
    ],
    [
        "question" => "Welke kleur krijg je als je blauw en geel mengt?",
        "answers" => ["Groen", "Paars", "Oranje", "Bruin"],
        "correct" => 0
    ],
    [
        "question" => "Wat is het grootste continent?",
        "answers" => ["Afrika", "Azië", "Europa", "Zuid-Amerika"],
        "correct" => 1
    ],
    [
        "question" => "Wat is de hoofdstad van Frankrijk?",
        "answers" => ["Parijs", "Berlijn", "Madrid", "Rome"],
        "correct" => 0
    ],
    [
        "question" => "Wie is de beste vriend van Spongebob?",
        "answers" => ["Octo", "MR.Krabs", "Patrick", "Gerrit"],
        "correct" => 2
    ],
    [
        "question" => "Hoeveel planeten heeft ons zonnestelsel?",
        "answers" => ["7", "8", "9", "10"],
        "correct" => 1
    ],
    [
        "question" => "Wat is het snelste landdier ter wereld?",
        "answers" => ["Leeuw", "Cheetah", "Luipaard", "Tijger"],
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
    $_SESSION['feedback'] = [];
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
        $_SESSION['feedback'][] = "Correct! De vraag \"" . $currentQuestion['question'] . "\" was goed beantwoord.";
    } else {
        $correctAnswerText = $currentQuestion['answers'][$currentQuestion['correct']];
        $_SESSION['feedback'][] = "Fout! De vraag \"" . $currentQuestion['question'] . "\" was fout beantwoord. Het juiste antwoord was \"$correctAnswerText\".";
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
    <title>Weet & Win Quiz</title>
</head>
<body>
    <h1>Weet & Win</h1>
    <div class="container">
        <?php if ($quizFinished): ?>
            <div class="result">
                <p>Je hebt de quiz voltooid!</p>
                <p>Je hebt <strong><?php echo $_SESSION['correctAnswers']; ?></strong> van de <strong><?php echo $_SESSION['totalQuestions']; ?></strong> vragen goed beantwoord.</p>
            </div>
            <div class="feedback">
                <h3>Feedback:</h3>
                <ul>
                    <?php foreach ($_SESSION['feedback'] as $feedback): ?>
                        <li><?php echo htmlspecialchars($feedback); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <form method="get">
                <button class="reset-button" name="reset">Opnieuw starten</button>
            </form>            
            <form method="get" action="Home screen.php">
                <button class="reset-button" >Terug naar beginscherm</button>
            </form>
        <?php else: ?>
            <div class="question">
                <p><?php echo htmlspecialchars($currentQuestion["question"]); ?></p>
            </div>
            <form method="POST" class="answers">
                <?php foreach ($currentQuestion["answers"] as $index => $answer): ?>
                    <button type="submit" name="answer" value="<?php echo $index; ?>">
                        <?php echo htmlspecialchars($answer); ?>
                    </button>
                <?php endforeach; ?>
            </form>            
            <div class="timer" id="timer">15</div>
        <?php endif; ?>
    </div>
    <script>
        let timeLeft = 15; // Timer starts at 15 seconds
        const timerElement = document.getElementById('timer');
        const quizForm = document.getElementById('quizForm');
        const hiddenAnswerInput = document.getElementById('hiddenAnswer');
        
        const countdown = setInterval(() => {
            if (timeLeft <= 0) {
                clearInterval(countdown);
                hiddenAnswerInput.value = "5"; // Zet het antwoord op leeg
                quizForm.submit(); // Automatisch formulier verzenden
            } else {
                timeLeft--;
                timerElement.textContent = timeLeft; // Update de timer op de pagina
            }
        }, 1000);
    </script>
</body>
</html>


