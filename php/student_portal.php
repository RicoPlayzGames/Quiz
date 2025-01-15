<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header('Location: login.php');
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
