<?php
include('../DB/config.php');

$dsn = "mysql:host=$dbHost;dbname=$dbName;charset=UTF8";
$pdo = new PDO($dsn, $dbUser, $dbPass);

// Controleer of er een id is meegegeven
if (!isset($_GET['id'])) {
    die("Geen reserverings-ID opgegeven.");
}

$id = $_GET['id'];

// Haal bestaande gegevens op
$sql = "SELECT * FROM Reservering WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id' => $id]);
$reservering = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$reservering) {
    die("Reservering niet gevonden.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Haal de ingevulde gegevens op
    $voornaam = $_POST['voornaam'];
    $tussenvoegsel = $_POST['tussenvoegsel'];
    $achternaam = $_POST['achternaam'];
    $nummer = $_POST['nummer'];
    $datum = $_POST['datum'];
    $tijd = $_POST['tijd'];
    $status = $_POST['status'];

    // Controleer of verplichte velden zijn ingevuld
    if (!empty($voornaam) && !empty($achternaam) && !empty($nummer) && !empty($datum) && !empty($tijd) && !empty($status)) {
        // SQL-query om gegevens bij te werken
        $sql = "UPDATE Reservering 
                SET Voornaam = :voornaam, Tussenvoegsel = :tussenvoegsel, Achternaam = :achternaam, 
                    Nummer = :nummer, Datum = :datum, Tijd = :tijd, Reserveringstatus = :status
                WHERE id = :id";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':voornaam' => $voornaam,
            ':tussenvoegsel' => $tussenvoegsel,
            ':achternaam' => $achternaam,
            ':nummer' => $nummer,
            ':datum' => $datum,
            ':tijd' => $tijd,
            ':status' => $status,
            ':id' => $id
        ]);

        // Stuur gebruiker terug naar de reserveringspagina
        header("Location: reservering.php");
        exit();
    } else {
        $error = "Vul alle verplichte velden in!";
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Reservering Wijzigen</title>
    <link rel="stylesheet" href="reservering.css">
</head>
<body>
    <div class="container mt-5">
        <h3>Reservering Wijzigen</h3>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Voornaam</label>
                <input type="text" name="voornaam" class="form-control" value="<?= htmlspecialchars($reservering['Voornaam']) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Tussenvoegsel</label>
                <input type="text" name="tussenvoegsel" class="form-control" value="<?= htmlspecialchars($reservering['Tussenvoegsel'] ?? '') ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Achternaam</label>
                <input type="text" name="achternaam" class="form-control" value="<?= htmlspecialchars($reservering['Achternaam']) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Nummer</label>
                <input type="text" name="nummer" class="form-control" value="<?= htmlspecialchars($reservering['Nummer']) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Datum</label>
                <input type="date" name="datum" class="form-control" value="<?= htmlspecialchars($reservering['Datum']) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Tijd</label>
                <input type="time" name="tijd" class="form-control" value="<?= htmlspecialchars($reservering['Tijd']) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Reserveringstatus</label>
                <select name="status" class="form-control" required>
                    <option value="">Selecteer een status</option>
                    <option value="In behandeling" <?= $reservering['Reserveringstatus'] == 'In behandeling' ? 'selected' : '' ?>>In behandeling</option>
                    <option value="Bevestigd" <?= $reservering['Reserveringstatus'] == 'Bevestigd' ? 'selected' : '' ?>>Bevestigd</option>
                    <option value="Geannuleerd" <?= $reservering['Reserveringstatus'] == 'Geannuleerd' ? 'selected' : '' ?>>Geannuleerd</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Wijzigen</button>
            <a href="reservering.php" class="btn btn-secondary">Annuleren</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
