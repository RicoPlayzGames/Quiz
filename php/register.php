<?php
require 'config.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];
    $role = $_POST['role'];

    // Validation
    if (empty($username) || empty($email) || empty($password) || empty($confirmPassword)) {
        $error = 'Alle velden moeten worden ingevuld.';
    } elseif ($password !== $confirmPassword) {
        $error = 'Wachtwoorden komen niet overeen.';
    } else {
        try {
            // Check if user already exists
            $stmt = $pdo->prepare('SELECT * FROM users WHERE username = :username OR email = :email');
            $stmt->execute(['username' => $username, 'email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                $error = 'De gebruikersnaam of het e-mailadres is al in gebruik.';
            } else {
                // Insert new user
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare('INSERT INTO users (username, email, password, role) VALUES (:username, :email, :password, :role)');
                $stmt->execute([
                    'username' => $username,
                    'email' => $email,
                    'password' => $hashedPassword,
                    'role' => $role
                ]);
                $success = 'Registratie succesvol!';
            }
        } catch (PDOException $e) {
            $error = 'Fout bij het registreren: ' . $e->getMessage();
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
    <link rel="Stylesheet" href="register.css">
    <a href="Home screen.php"><img src="Logo Quiz.png" alt="Logo quiz" class="logo"></a>
</head>
<body>
    <?php if ($error): ?>
        <p class="error"> <?php echo htmlspecialchars($error); ?> </p>
    <?php elseif ($success): ?>
        <p class="success"> <?php echo htmlspecialchars($success); ?> </p>
    <?php endif; ?>
    <form method="POST">
    <h1>Registreren</h1>
    
        <label for="username">Gebruikersnaam:</label>
        <input type="text" id="username" name="username" required>

        <label for="email">E-mailadres:</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Wachtwoord:</label>
        <input type="password" id="password" name="password" required>

        <label for="confirm_password">Bevestig wachtwoord:</label>
        <input type="password" id="confirm_password" name="confirm_password" required>

        <label for="role">Rol:</label>
        <select id="role" name="role" required>
            <option value="student">Student</option>
            <option value="teacher">Docent</option>
        </select>

        <button type="submit">Registreren</button>
    </form>
    <p class="login-prompt">Al een account? <a href="login.php" class="login-link">Log in</a>.</p>
</body>
</html>

