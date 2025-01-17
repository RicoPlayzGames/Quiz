<?php
session_start();
require 'config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Gebruiker opzoeken in de database
    $stmt = $pdo->prepare("SELECT * FROM users WHERE Email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && hash('sha512', $password) === $user['Password_hash']) {
    // Sessie starten
    $_SESSION['user_id'] = $user['User      _id'];
    $_SESSION['role'] = $user['Role'];

    // Redirect op basis van rol
    if ($user['Role'] === 'student') {
        header('Location: /php/student_portal.php');
    } elseif ($user['Role'] === 'teacher') {
        header('Location: /php/teacher_portal.php');
    }
    exit;
} else {
    $error = 'Ongeldige inloggegevens.';
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <?php if ($error): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="POST">
        <label for="email">E-mail:</label><br>
        <input type="email" id="email" name="email" required><br><br>
        <label for="password">Wachtwoord:</label><br>
        <input type="password" id="password" name="password" required><br><br>
        <button type="submit">Inloggen</button>
    </form>
</body>
</html>
