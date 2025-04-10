<?php
include('../DB/config.php');

$dsn = "mysql:host=$dbHost;dbname=$dbName;charset=UTF8";
$pdo = new PDO($dsn, $dbUser, $dbPass);

if (!isset($_GET['id'])) {
    die("Geen les-ID opgegeven.");
}

$id = $_GET['id'];

$sql = "SELECT * FROM Les WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id' => $id]);
$les = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$les) {
    die("Les niet gevonden.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $naam = $_POST['naam'];
    $datum = $_POST['datum'];
    $tijd = $_POST['tijd'];
    $min = $_POST['min'];
    $max = $_POST['max'];
    $beschikbaar = $_POST['beschikbaar'];

    if (!empty($naam) && !empty($datum) && !empty($tijd)) {
        $sql = "UPDATE Les SET 
                    Naam = :naam,
                    Datum = :datum,
                    Tijd = :tijd,
                    MinAantalPersonen = :min,
                    MaxAantalPersonen = :max,
                    Beschikbaarheid = :beschikbaar
                WHERE id = :id";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':naam' => $naam,
            ':datum' => $datum,
            ':tijd' => $tijd,
            ':min' => $min,
            ':max' => $max,
            ':beschikbaar' => $beschikbaar,
            ':id' => $id
        ]);

        header("Location: lessen2.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Les bewerken</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Farro:wght@300;400;500;700&family=Luckiest+Guy&family=Passion+One:wght@400;700;900&display=swap" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-custom sticky">
    <div class="container-fluid">
        <ul>
            <li>
                <img src="../Image/Logo.png" alt="logo" class="logo">
            </li>
        </ul>
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="../index.html">Homepage</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="../lessen.php">Lessen</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../dashboard/dashboard.html">Dashboard</a>
            </li>
        </ul>
    </div>
</nav>

<div class="container mt-5">
    <div class="row mb-3">
        <div class="col-12 text-center">
            <h2>Les bewerken</h2>
        </div>
    </div>
    <form method="POST" class="row g-3">
        <div class="col-md-6 offset-md-3">
            <label class="form-label">Naam</label>
            <input type="text" name="naam" class="form-control" value="<?= $les['Naam'] ?>" required>
        </div>
        <div class="col-md-3 offset-md-3">
            <label class="form-label">Datum</label>
            <input type="date" name="datum" class="form-control" value="<?= $les['Datum'] ?>" required>
        </div>
        <div class="col-md-3">
            <label class="form-label">Tijd</label>
            <input type="time" name="tijd" class="form-control" value="<?= $les['Tijd'] ?>" required>
        </div>
        <div class="col-md-3 offset-md-3">
            <label class="form-label">Min. Personen</label>
            <input type="number" name="min" class="form-control" value="<?= $les['MinAantalPersonen'] ?>" required>
        </div>
        <div class="col-md-3">
            <label class="form-label">Max. Personen</label>
            <input type="number" name="max" class="form-control" value="<?= $les['MaxAantalPersonen'] ?>" required>
        </div>
        <div class="col-md-6 offset-md-3">
            <label class="form-label">Beschikbaarheid</label>
            <input type="text" name="beschikbaar" class="form-control" value="<?= $les['Beschikbaarheid'] ?>">
        </div>
        <div class="col-md-6 offset-md-3 text-center mt-3">
            <button type="submit" class="btn btn-success">Opslaan</button>
            <a href="lessen.php" class="btn btn-secondary">Annuleren</a>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
