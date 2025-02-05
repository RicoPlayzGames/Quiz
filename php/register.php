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
    <img src="Logo Quiz.png" alt="Logo quiz" class="logo">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color:rgb(179, 178, 178);
            background-size: 100px;
            background-position: center;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        h1 {
            text-align: center;
            color: black;
            margin-bottom: 20px;
        }

        form {
            background: #fff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            max-width: 400px;
            width: 100%;
        }
        .logo {
        width: 150px; 
        height: auto; 
        display: block;
        margin: 0 auto 20px; 
        position: absolute;
        top: 10px; /* Afstand vanaf de bovenkant */
        left: 10px; /* Afstand vanaf de linkerkant */
        width: 150px; /* Houd de grootte consistent */
        height: auto; /* Zorg ervoor dat de verhoudingen behouden blijven */
}

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
            color: #333;
        }

        input, select, button {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
        }

        input:focus, select:focus {
            border-color: #007BFF;
            outline: none;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }
        

        button {
            background-color:rgb(225, 248, 21);
            color: white;
            border: none;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color:rgb(116, 125, 0);
        }

        p {
            text-align: center;
        
        }

        a {
            color: #007BFF;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }

        .error {
            color: red;
            text-align: center;
            margin-bottom: 15px;
            font-size: 14px;
        }

        .success {
            color: green;
            text-align: center;
            margin-bottom: 15px;
            font-size: 14px;
        }

        .login-prompt {
            text-align: center;
            font-size: 16px;
            color: #000;
            margin-top: 20px;
        }

        .login-prompt .login-link {
            color: #007BFF;
            text-decoration: none;
            font-weight: bold;
        }

        .login-prompt .login-link:hover {
            text-decoration: underline;
            color: #0056b3;
        }
    </style>
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

