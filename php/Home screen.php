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
    background: linear-gradient(to bottom, #87ceeb, #4682b4); 
    color: #333;
}

.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: white;
    padding: 15px 30px;
    border-bottom: 2px solid #ccc;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.logo {
    width: 120px;
    height: auto;
}

.nav-bar {
    display: flex;
    align-items: center;
    gap: 50px;
    margin-right: 30px;
}

.nav-bar a {
    text-decoration: none;
    color: #333;
    font-weight: bold;
    font-size: 16px;
    transition: color 0.3s ease;
}

.nav-bar a:hover {
    color: #007BFF;
}

#register, #login {
    padding: 8px 15px;
    font-size: 14px;
    font-weight: bold;
    color: white;
    background-color:rgb(144, 160, 0);
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

#register:hover, #login:hover {
    background-color: #0056b3;
}

.search-bar {
    flex-grow: 1;
    display: flex;
    justify-content: center;
    margin-right: 20px;
}

.search-bar input {
    width: 800px;
    padding: 10px 15px;
    border: 1px solid #ccc;
    border-radius: 20px;
    font-size: 16px;
    transition: box-shadow 0.3s ease;
}

.search-bar input:focus {
    outline: none;
    box-shadow: 0 0 8px rgba(0, 123, 255, 0.5);
    border-color: #007BFF;
}

.main-content {
    padding: 40px;
    display: flex;
    justify-content: center;
    align-items: center;
}

.quiz-section {
    flex: 3;
    background-color: white;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    max-width: 1200px;
    margin: auto;
    text-align: center;
}

.quiz-section h2 {
    margin-bottom: 20px;
    font-size: 24px;
    color: #333;
    font-weight: bold;
}

.quiz-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    font-size: 18px;
}

.quiz-item {
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: #f9f9f9;
    border: 2px solid #ccc;
    border-radius: 10px;
    height: 120px;
    font-weight: bold;
    text-align: center;
    transition: transform 0.3s ease, background-color 0.3s ease;
    cursor: pointer;
}

.quiz-item:hover {
    transform: scale(1.05);
    background-color: #007BFF;
    color: white;
    border-color: #0056b3;
}

@media (max-width: 1200px) {
    .quiz-grid {
        grid-template-columns: repeat(3, 1fr);
    }

    .search-bar input {
        width: 600px;
    }
}

@media (max-width: 768px) {
    .quiz-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .search-bar input {
        width: 100%;
    }

    .header {
        flex-wrap: wrap;
    }

    .nav-bar {
        gap: 20px;
        margin-top: 10px;
    }
}

@media (max-width: 480px) {
    .quiz-grid {
        grid-template-columns: 1fr;
    }

    .nav-bar {
        flex-direction: column;
        align-items: flex-start;
    }

    .search-bar input {
        width: 100%;
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
            <a href="quiz.php"><img src="Verbeterde Profielfoto quiz.png" alt="Logo quiz" class="quiz-item"></a>
            <a class="quiz-item" href="">Empty Quiz</a>
            <a class="quiz-item" href="">Empty Quiz</a>
            </div>
        </section>
    </div>
</body>
</html>

