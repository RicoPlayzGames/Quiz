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
        "correct" => 3
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
    <title>Weet & Win</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            text-align: center;
            margin: 0;
            padding: 0;
            background: linear-gradient(to bottom, #87ceeb, #4682b4); 
            color: #333;
        }
        h1 {
            color: #ffffff;
            font-size: 3rem;
            margin: 20px 0;
        }
        .logo {
            width: 120px;
            height: 120px;
            background: url('DALL_E_2025-01-13_11.14.57_-_A_vibrant_and_dynamic_logo_design_for_a_quiz_program_called_Weet___Win._The_logo_features_bold__playful_fonts_with_a_modern_style__incorporating_a_m-removebg-preview.png') no-repeat center;
            background-size: contain;
            margin: 20px auto;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .question {
            margin: 30px 0;
            font-size: 2rem;
            color: #4682b4;
        }
        .answers {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin: 20px 0;
        }
        .answers button {
            font-size: 1.2rem;
            padding: 20px;
            background-color: #f4f4f4;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            color: #333;
            transition: transform 0.2s, background-color 0.3s;
        }
        .answers button:nth-child(1) {
            background-color: #ff6b6b;
            color: #fff;
        }
        .answers button:nth-child(2) {
            background-color: #4ecdc4;
            color: #fff;
        }
        .answers button:nth-child(3) {
            background-color: #ffe66d;
            color: #333;
        }
        .answers button:nth-child(4) {
            background-color: #1b9aaa;
            color: #fff;
        }
        .answers button:hover {
            transform: scale(1.1);
        }
        .timer {
            position: fixed;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 2rem;
            color: #fff;
            background: rgba(0, 0, 0, 0.5);
            padding: 10px 20px;
            border-radius: 10px;
        }
        .result {
            font-size: 1.5rem;
            color: #333;
        }
        .feedback {
            text-align: left;
            margin-top: 20px;
        }
        .feedback h3 {
            color: #4682b4;
        }
        .reset-button {
            margin-top: 30px;
            padding: 10px 20px;
            font-size: 1rem;
            background-color: #4682b4;
            color: #fff;
            border: none;
            cursor: pointer;
            border-radius: 10px;
        }
        .reset-button:hover {
            background-color: #4169e1;
        }
    </style>
</head>
<body>
    <div class="logo"></div>
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
            <form method="POST" class="answers" id="quizForm">
                <?php foreach ($currentQuestion["answers"] as $index => $answer): ?>
                    <button type="submit" name="answer" value=""<?php echo $index; ?>">
                        <?php echo htmlspecialchars($answer); ?>
                    </button>
                <?php endforeach; ?>
                <input type="hidden" name="answer" id="hiddenAnswer" value="">
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

