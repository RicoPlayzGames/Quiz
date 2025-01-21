<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beginscherm</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: rgb(179, 178, 178);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: white;
            padding: 10px 20px;
            border-bottom: 1px solid #ccc;
        }

        .logo {
            width: 100px;
            height: auto;
        }

        .nav-bar {
            display: flex;
            align-items: center;
            gap: 80px; 
            margin-left: -60px; 
            margin-right: 80px;
        }

        #register {
            margin-right: 10px; 
        }

        #login {}

        .nav-bar a {
            text-decoration: none;
            color: black;
            font-weight: bold;
            font-size: 18px;
            margin-left: 20px;
        }

        .nav-bar a:hover {
            color: #007BFF;
        }

        .search-bar {
            flex-grow: 1;
            margin: 0 20px 0 0; 
            display: flex;
            justify-content: center;
            margin-right: 20px;
        }

        .search-bar input {
            width: 800px;
            padding: 6px 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .main-content {
            display: 100px;
            margin: 20px;
        }

        .quiz-section {
            flex: 3;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .quiz-section h2 {
            text-align: center;
            margin-bottom:450px;
        }

        .quiz-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            font-size: 30px;
            transform: translateY(-400px);
            margin-left: 250px;
        }

        .quiz-item {
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f9f9f9;
            border: 1px solid #ccc;
            border-radius: 5px;
            height: 100px;
            font-weight: bold;
            text-align: center;
        }


        @media (max-width: 768px) {
            .main-content {
                flex-direction: column;
            }

            .quiz-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>
<body>
    <header class="header">
        <img src="Logo Quiz.png" alt="Logo" class="logo">
        <div class="search-bar">
            <input type="text" placeholder="Zoek naar quizzen...">
        </div>
        <nav class="nav-bar">
            <a id="register" href="register.php">Sign up</a>
            <a id="login" href="login.php">Login</a>
        </nav>
    </header>

    <div class="main-content">
        <section class="quiz-section">
            <h2>Speelbare quizzen</h2>
            <div class="quiz-grid">
            <a href="quiz.php"><img src="Profielfoto quiz 1.png" alt="Logo quiz" class="quiz-item"></a>
            <a class="quiz-item" href="">Quiz</a>
            <a class="quiz-item" href="">Quiz</a>
            </div>
        </section>
    </div>
</body>
</html>

