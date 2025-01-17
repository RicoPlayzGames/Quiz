<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SESSION['role'] !== 'student') { // Of 'teacher' voor docentportaal
    header('Location: unauthorized.php'); // Toon een foutpagina als rol niet klopt
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Studentenportaal</title>
</head>
<body>
    <h1>Welkom, Student</h1>
    <p>Hier kun je quizzen starten.</p>
    <a href="logout.php">Uitloggen</a>
</body>
</html>
