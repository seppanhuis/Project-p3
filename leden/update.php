<?php
include('../DB/config.php');

$dsn = "mysql:host=$dbHost;dbname=$dbName;charset=UTF8";
$pdo = new PDO($dsn, $dbUser, $dbPass);

if (isset($_POST['submit'])) {
    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // Controleer of het e-mailadres al bestaat bij een ander lid
    $sqlCheck = "SELECT COUNT(*) FROM Lid WHERE Email = :email AND Id != :id";
    $checkStmt = $pdo->prepare($sqlCheck);
    $checkStmt->bindValue(':email', $_POST['Email'], PDO::PARAM_STR);
    $checkStmt->bindValue(':id', $_POST['Id'], PDO::PARAM_INT);
    $checkStmt->execute();
    $emailExists = $checkStmt->fetchColumn();

    if ($emailExists) {
        $error = "Dit e-mailadres is al in gebruik bij een ander lid.";
    } else {
        $sql = "UPDATE Lid SET
                    Voornaam = :voornaam,
                    Tussenvoegsel = :tussenvoegsel,
                    Achternaam = :achternaam,
                    Relatienummer = :relatienummer,
                    Mobiel = :mobiel,
                    Email = :email,
                    DatumGewijzigd = SYSDATE(6)
                WHERE Id = :id";

        $statement = $pdo->prepare($sql);
        $statement->bindValue(':voornaam', trim($_POST['Voornaam']), PDO::PARAM_STR);
        $statement->bindValue(':tussenvoegsel', trim($_POST['Tussenvoegsel']), PDO::PARAM_STR);
        $statement->bindValue(':achternaam', trim($_POST['Achternaam']), PDO::PARAM_STR);
        $statement->bindValue(':relatienummer', trim($_POST['Relatienummer']), PDO::PARAM_INT);
        $statement->bindValue(':mobiel', trim($_POST['Mobiel']), PDO::PARAM_STR);
        $statement->bindValue(':email', trim($_POST['Email']), PDO::PARAM_STR);
        $statement->bindValue(':id', trim($_POST['Id']), PDO::PARAM_INT);
        $statement->execute();

        $display = 'flex';
        header('Refresh:3; url=leden.php');
    }
} else {
    $sql = "SELECT * FROM Lid WHERE Id = :id";
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':id', $_GET['Id'], PDO::PARAM_INT);
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_OBJ);
}
?>
<!doctype html>
<html lang="nl">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lid Wijzigen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
    <div class="container mt-3">
      <div class="row" style="display:<?= $display ?? 'none'; ?>">
        <div class="col-3"></div>
        <div class="col-6">
          <div class="alert alert-success text-center" role="alert">
            De wijziging is doorgevoerd, u wordt doorgestuurd naar de ledenpagina
          </div>
        </div>
        <div class="col-3"></div>
      </div>

      <?php if (isset($error)): ?>
        <div class="alert alert-danger text-center"><?= $error; ?></div>
      <?php endif; ?>

      <div class="row mb-1">
        <div class="col-3"></div>
        <div class="col-6 text-primary"><h3>Wijzig lidgegevens</h3></div>
        <div class="col-3"></div>
      </div>

      <div class="row">
        <div class="col-3"></div>
        <div class="col-6">              
          <form action="update.php" method="POST">
            <div class="mb-3">
              <label for="Voornaam" class="form-label">Voornaam</label>
              <input name="Voornaam" type="text" class="form-control" id="Voornaam" value="<?= $result->Voornaam ?? $_POST['Voornaam']; ?>" required>
            </div>
            <div class="mb-3">
              <label for="Tussenvoegsel" class="form-label">Tussenvoegsel</label>
              <input name="Tussenvoegsel" type="text" class="form-control" id="Tussenvoegsel" value="<?= $result->Tussenvoegsel ?? $_POST['Tussenvoegsel']; ?>">
            </div>
            <div class="mb-3">
              <label for="Achternaam" class="form-label">Achternaam</label>
              <input name="Achternaam" type="text" class="form-control" id="Achternaam" value="<?= $result->Achternaam ?? $_POST['Achternaam']; ?>" required>
            </div>
            <div class="mb-3">
              <label for="Relatienummer" class="form-label">Relatienummer</label>
              <input name="Relatienummer" type="number" class="form-control" id="Relatienummer" value="<?= $result->Relatienummer ?? $_POST['Relatienummer']; ?>" required>
            </div>
            <div class="mb-3">
              <label for="Mobiel" class="form-label">Mobiel</label>
              <input name="Mobiel" type="text" class="form-control" id="Mobiel" value="<?= $result->Mobiel ?? $_POST['Mobiel']; ?>" required>
            </div>
            <div class="mb-3">
              <label for="Email" class="form-label">Email</label>
              <input name="Email" type="email" class="form-control" id="Email" value="<?= $result->Email ?? $_POST['Email']; ?>" required>
            </div>

            <input type="hidden" name="Id" value="<?= $result->Id ?? $_POST['Id']; ?>">

            <div class="d-grid gap-2">
              <button name="submit" value="submit" type="submit" class="btn btn-primary btn-lg">Wijzigen</button>
            </div>
          </form>
        </div>
        <div class="col-3"></div>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
