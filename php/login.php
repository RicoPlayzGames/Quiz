<?php
session_start();
require 'config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email']; // changed 'email' to match the input field
    $password = $_POST['password']; // changed 'password' to match the input field

    // Validate email and password
    if (empty($email) || empty($password)) {
        $error = 'Alle velden moeten worden ingevuld.';
    } else {
        try {
            // Check if user exists
            $stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email');
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                // Hash the input password
                $hashedInputPassword = password_hash($password, PASSWORD_DEFAULT);
             
                // Compare the newly hashed password with the database hash
                if (hash_equals($hashedInputPassword, $user['password'])) {
                    // Correct password
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['role'] = $user['role'];
                    $_SESSION['username'] = $user['username'];
             
                    // Redirect based on role
                    if ($user['role'] === 'teacher') {
                        header('Location: teacher_portal.php');
                    } else {
                        header('Location: student_portal.php');
                    }
                    exit;

                } else {
                    // Password is incorrect
                    $error = 'Ongeldige inloggegevens.';
                }
            } else {
                $error = 'Ongeldige inloggegevens.';
            }
        } catch (PDOException $e) {
            $error = 'Fout bij het inloggen: ' . $e->getMessage();
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <a href="Home screen.php"><img src="Logo Quiz.png" alt="Logo quiz" class="logo"></a>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <?php if ($error): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>
    
    <form action="login.php" method="POST" autocomplete="on">
        <h1>Login</h1>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" autocomplete="email">
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" autocomplete="current-password">
        
        <button type="submit">Login</button>
    </form>
    <p class="login-prompt">Nog geen account? <a href="register.php" class="login-link">Account aanmaken</a>.</p>
</body>
</html>
