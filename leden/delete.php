<?php
// Stap 1: check of ID is meegegeven
if (!isset($_GET['Id'])) {
    echo "Geen ID opgegeven.";
    exit;
}

$id = $_GET['Id'];

// Stap 2: Als gebruiker nog niet bevestigd heeft
if (!isset($_POST['bevestigen'])) {
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Bevestig verwijdering</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
  <div class="alert alert-warning text-center">
    <h4>Weet je zeker dat je dit lid wilt verwijderen?</h4>
    <form method="post">
      <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
      <button type="submit" name="bevestigen" class="btn btn-danger">Ja, verwijder</button>
      <a href="leden.php" class="btn btn-secondary">Annuleren</a>
    </form>
  </div>
</div>
</body>
</html>
<?php
exit;
}

// Stap 3: Verwijder na bevestiging
include('../DB/config.php');
$dsn = "mysql:host=$dbHost;dbname=$dbName;charset=UTF8";
$pdo = new PDO($dsn, $dbUser, $dbPass);

$sql = "DELETE FROM Lid WHERE Id = :id";
$statement = $pdo->prepare($sql);
$statement->bindValue(':id', $_POST['id'], PDO::PARAM_INT);
$statement->execute();

header('Refresh:3; url=leden.php');
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Verwijder record</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container mt-3">
    <div class="alert alert-success text-center">
      Het verwijderen is gelukt
    </div>
  </div>
</body>
</html>
