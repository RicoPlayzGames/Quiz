<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "quiz";

try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  echo "<script>console.log('Connected successfully');</script>";
} catch(PDOException $e) {
  echo "<script>console.log('Connection failed: " . $e->getMessage() . "');</script>";
}

$showAlert = false;
$showError = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username_or_email = $_POST["username_or_email"];
  $password = $_POST["password"];

  $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username_or_email OR email = :username_or_email");
  $stmt->bindParam(':username_or_email', $username_or_email);
  $stmt->execute();
  $user = $stmt->fetch();

  $password_hash = password_hash($password, PASSWORD_DEFAULT);

  if ($user && password_verify($password, $user["password"])) {
    // Gebruiker inloggen
    $_SESSION["username"] = $user["username"];
    $_SESSION["role"] = $user["role"];
    if ($user["role"] == "student") {
      header("Location: student_portal.php");
    } elseif ($user["role"] == "teacher") {
      header("Location: teacher_portal.php");
    }
    exit;
  } else {
    $showError = "Ongeldige gebruikersnaam of wachtwoord";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<<<<<<< HEAD
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <img src="Logo Quiz.png" alt="Logo quiz" class="logo">
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
        .logo {
            width: 150px; 
            height: auto;
            display: block;
            margin: 0 auto 20px; 
        }
=======
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
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
>>>>>>> b9f4bcedaf52f3cea983fa9db0b38bdfbd330e26

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
<<<<<<< HEAD
    <?php if ($error): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="POST">
        <h1>Login</h1>
    <label for="username">Gebruikersnaam:</label>
    <input type="text" id="username" name="username" required>
        <label for="password">Wachtwoord:</label><br>
        <input type="password" id="password" name="password" required><br><br>
        <button type="submit">Inloggen</button>
    </form>
    <p class="register-prompt">Nog geen account? <a href="register.php" class="login-link">Account aanmaken</a>.</p>
=======

  <h1>Login</h1>

  <?php
  if ($showAlert) {
    echo '<div class="success">Je account is succesvol aangemaakt en je kunt inloggen.</div>';
  }

  if ($showError) {
    echo '<div class="error">' . $showError . '</div>';
  }
  ?>

  <form action="" method="POST">
    <label for="username_or_email">Gebruikersnaam of e-mailadres:</label>
    <input type="text" id="username_or_email" name="username_or_email" required>

    <label for="password">Wachtwoord:</label>
    <input type="password" id="password" name="password" required>

    <button type="submit">Inloggen</button>
  </form>

  <p class="login-prompt">Nog geen account? <a href="register.php">Registreer hier</a></p>

>>>>>>> b9f4bcedaf52f3cea983fa9db0b38bdfbd330e26
</body>
</html>