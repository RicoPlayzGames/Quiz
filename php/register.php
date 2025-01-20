<?php
require 'config.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username']);
  $email = trim($_POST['email']);
  $password = trim($_POST['password']);
  $confirm_password = trim($_POST['confirm_password']);
  $role = trim($_POST['role']);

  // Validatie
  if (empty($username) || empty($email) || empty($password) || empty($confirm_password) || empty($role)) {
    $error = 'Alle velden zijn verplicht.';
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error = 'Ongeldig e-mailadres.';
  } elseif ($password !== $confirm_password) {
    $error = 'Wachtwoorden komen niet overeen.';
  } else {
    try {
      // Controleren of het e-mailadres al bestaat
      $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
      $stmt->execute(['email' => $email]);
      $user = $stmt->fetch();

      if ($user) {
        $error = 'E-mailadres is al geregistreerd.';
      } else {
        // Wachtwoord hashen
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        // Nieuwe gebruiker toevoegen
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password, role) VALUES (:username, :email, :password, :role)");
        $stmt->execute([
          'username' => $username,
          'email' => $email,
          'password' => $password_hash,
          'role' => $role
        ]);

        $success = 'Registratie voltooid! U kunt nu inloggen.';
        header('Location: login.php');
        exit;
      }
    } catch (PDOException $e) {
      $error = 'Er is een fout opgetreden: ' . $e->getMessage();
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
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: Grey;
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

  </style>
</head>
<body>
  <h1>Registreren</h1>

  <?php if ($error): ?>
    <p class="error"> <?php echo htmlspecialchars($error); ?> </p>
  <?php elseif ($success): ?>
    <p class="success"> <?php echo htmlspecialchars($success); ?> </p>
  <?php endif; ?>
  <form method="POST">
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