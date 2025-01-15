<?php
// Databaseconfiguratie
$host = 'localhost'; // Servernaam
$db = 'quiz';        // Naam van de database
$user = 'root';      // Gebruikersnaam (standaard voor XAMPP)
$pass = '';          // Wachtwoord (standaard leeg voor XAMPP)

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Fout bij verbinden met de database: " . $e->getMessage());
}
?>
