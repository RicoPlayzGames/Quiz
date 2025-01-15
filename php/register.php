<?php
require 'config.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = $_POST['role'];

    // Validatie
    if (empty($username) || empty($email) || empty($password) || empty($role)) {
        $error = 'Alle velden zijn verplicht.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Ongeldig e-mailadres.';
    } elseif ($password !== $confirm_password) {
        $error = 'Wachtwoorden komen niet overeen.';
    } else {
        // Controleren of het e-mailadres al bestaat
        $stmt = $pdo->prepare("SELECT * FROM users WHERE Email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $error = 'E-mailadres is al geregistreerd.';
        } else {
            // Wachtwoord hashen
            $password_hash = hash('sha256', $password);

            // Nieuwe gebruiker toevoegen
            $stmt = $pdo->prepare("
                INSERT INTO users (Username, Password_hash, Email, Role) 
                VALUES (:username, :password_hash, :email, :role)
            ");

            $stmt->execute([
                'username' => $username,
                'password_hash' => $password_hash,
                'email' => $email,
                'role' => $role
            ]);

            $success = 'Registratie voltooid! U kunt nu inloggen.';
            header('Location: login.php');
exit;

        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registreren</title>
</head>
<body>
    <h1>Registreren</h1>
    <?php if ($error): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php elseif ($success): ?>
        <p style="color: green;"><?php echo $success; ?></p>
    <?php endif; ?>
    <form method="POST">
        <label for="username">Gebruikersnaam:</label><br>
        <input type="text" id="username" name="username" required><br><br>

        <label for="email">E-mailadres:</label><br>
        <input type="email" id="email" name="email" required><br><br>

        <label for="password">Wachtwoord:</label><br>
        <input type="password" id="password" name="password" required><br><br>

        <label for="confirm_password">Bevestig wachtwoord:</label><br>
        <input type="password" id="confirm_password" name="confirm_password" required><br><br>

        <label for="role">Rol:</label><br>
        <select id="role" name="role" required>
            <option value="student">Student</option>
            <option value="teacher">Docent</option>
        </select><br><br>

        <button type="submit">Registreren</button>
    </form>
    <p>Al een account? <a href="login.php">Log in</a>.</p>
</body>
</html>
