<?php
include('../DB/config.php');

if (isset($_GET['id'])) {
    $lesId = $_GET['id'];

    if (!empty($lesId) && is_numeric($lesId)) {
        try {
            $dsn = "mysql:host=$dbHost;dbname=$dbName;charset=UTF8";
            $pdo = new PDO($dsn, $dbUser, $dbPass);

            $pdo->beginTransaction();

            $sql = "DELETE FROM Les WHERE Id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':id' => $lesId]);

            $pdo->commit();

            header("Location: lessen2.php");
            exit();

        } catch (Exception $e) {
            $pdo->rollBack();
            echo "Fout bij verwijderen: " . $e->getMessage();
        }
    } else {
        echo "Ongeldig ID.";
    }
} else {
    echo "Geen ID opgegeven.";
}
