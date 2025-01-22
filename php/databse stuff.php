<?php
// Database Configuration
// Set up connection details to the MySQL database
$host = "127.0.0.1"; // Localhost address
$username = "root"; // Database username
$password = ""; // Database password
$dbname = "test"; // Database name

// Create Connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check Connection
if ($conn->connect_error) {
    // Exit the script if the connection fails
    die("Connection failed: " . $conn->connect_error);
}

// Function to Fetch Quiz Questions
function fetchQuizQuestions($quizId) {
    global $conn;
    // SQL query to fetch questions for a specific quiz
    $query = "SELECT * FROM questions WHERE Quiz_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $quizId); // Bind quiz ID to the query
    $stmt->execute();
    $result = $stmt->get_result();

    // Initialize an array to store questions
    $questions = [];
    while ($row = $result->fetch_assoc()) {
        $questions[] = $row; // Add each question to the array
    }
    return $questions; // Return the array of questions
}

// Function to Submit User Answers
function submitAnswers($userId, $quizId, $answers) {
    global $conn;
    foreach ($answers as $questionId => $userAnswer) {
        // SQL query to fetch the correct answer and explanation for each question
        $query = "SELECT * FROM questions WHERE Question_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $questionId); // Bind question ID to the query
        $stmt->execute();
        $result = $stmt->get_result();
        $question = $result->fetch_assoc();

        // Compare user's answer with the correct answer (case-insensitive)
        $isCorrect = (strtolower(trim($userAnswer)) === strtolower(trim($question['CorrectAnswer'])));
        $explanation = $question['Explanation'];

        // Insert feedback into the database
        $insertQuery = "INSERT INTO questionfeedback (UserID, QuizID, QuestionID, UserAnswer, IsCorrect, Explanation) VALUES (?, ?, ?, ?, ?, ?)";
        $insertStmt = $conn->prepare($insertQuery);
        $insertStmt->bind_param("iiiiss", $userId, $quizId, $questionId, $userAnswer, $isCorrect, $explanation);
        $insertStmt->execute();
    }
}

// Function to Display the Leaderboard
function displayLeaderboard($quizId) {
    global $conn;
    // SQL query to fetch leaderboard data for a specific quiz
    $query = "SELECT u.Username, l.score FROM leaderboard l JOIN users u ON l.User_id = u.User_id WHERE l.Quiz_id = ? ORDER BY l.score DESC";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $quizId); // Bind quiz ID to the query
    $stmt->execute();
    $result = $stmt->get_result();

    // Display the leaderboard in an HTML unordered list
    echo "<h3>Leaderboard</h3><ul>";
    while ($row = $result->fetch_assoc()) {
        echo "<li>" . htmlspecialchars($row['Username']) . ": " . htmlspecialchars($row['score']) . "</li>";
    }
    echo "</ul>";
}

// Function to Create a New Quiz
function createQuiz($creatorId, $title, $description, $questions) {
    global $conn;

    // Insert quiz details into the quizzes table
    $quizQuery = "INSERT INTO quizzes (Creator_id, Title, Description) VALUES (?, ?, ?)";
    $quizStmt = $conn->prepare($quizQuery);
    $quizStmt->bind_param("iss", $creatorId, $title, $description);
    $quizStmt->execute();
    $quizId = $conn->insert_id; // Get the auto-generated quiz ID

    // Insert each question into the questions table
    foreach ($questions as $questionText) {
        $questionQuery = "INSERT INTO questions (Quiz_id, Question_text) VALUES (?, ?)";
        $questionStmt = $conn->prepare($questionQuery);
        $questionStmt->bind_param("is", $quizId, $questionText);
        $questionStmt->execute();
    }

    return $quizId; // Return the quiz ID
}

// Function to Register a New User
function registerUser($username, $password, $email, $role = 'student') {
    global $conn;
    // Hash the user's password for secure storage
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    // Insert user details into the users table
    $query = "INSERT INTO users (Username, password, Email, Role) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssss", $username, $hashedPassword, $email, $role);
    $stmt->execute();
}

// Function to Log In a User
function loginUser($username, $password) {
    global $conn;
    // SQL query to fetch user details by username
    $query = "SELECT * FROM users WHERE Username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username); // Bind username to the query
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Verify the provided password against the hashed password in the database
    if ($user && password_verify($password, $user['password'])) {
        return $user; // Return user details if login is successful
    }
    return null; // Return null if login fails
}
?>
