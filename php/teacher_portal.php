<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'teacher') {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Docentenportaal</title>
</head>
<body>
    <h1>Welkom, Docent</h1>
    <p>Hier kun je quizzen beheren en resultaten bekijken.</p>
    <a href="logout.php">Uitloggen</a>
</body>
</html>
