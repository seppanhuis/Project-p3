<?php
include('../DB/config.php');

// Check of het 'id' is meegegeven in de URL
if (isset($_GET['id'])) {
    $reserveringId = $_GET['id'];

    // Check of het ID geldig is
    if (!empty($reserveringId) && is_numeric($reserveringId)) {
        try {
            // Maak verbinding met de database
            $dsn = "mysql:host=$dbHost;dbname=$dbName;charset=UTF8";
            $pdo = new PDO($dsn, $dbUser, $dbPass);

            // Begin een transactie voor veilige uitvoering van de delete
            $pdo->beginTransaction();

            // Verwijder de reservering uit de database
            $sql = "DELETE FROM Reservering WHERE Id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':id' => $reserveringId]);

            // Commit de transactie als de verwijdering succesvol is
            $pdo->commit();

            // Redirect terug naar de reserveringenpagina
            header("Location: reservering.php");
            exit();

        } catch (Exception $e) {
            // Als er iets misgaat, rollback de transactie
            $pdo->rollBack();
            echo "Er is iets misgegaan bij het verwijderen van de reservering: " . $e->getMessage();
        }
    } else {
        echo "Ongeldig reservering ID.";
    }
} else {
    echo "Geen reservering ID meegegeven.";
}
?>
