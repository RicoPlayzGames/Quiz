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

            if ($user && password_verify($password, $user['password'])) {
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
            top: 10px;
            left: 10px;
            width: 150px;
            height: auto;
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
