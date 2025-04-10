<?php
include('../DB/config.php');

$dsn = "mysql:host=$dbHost;dbname=$dbName;charset=UTF8";
$pdo = new PDO($dsn, $dbUser, $dbPass);

$sql = "SELECT Id, Naam, Datum, Tijd, MinAantalPersonen, MaxAantalPersonen, lesPrijs, Beschikbaarheid FROM Les";
$statement = $pdo->prepare($sql);
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lessenoverzicht</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-custom sticky">
        <div class="container-fluid">
            <ul>
                <li><img src="../Image/Logo.png" alt="logo" class="logo"></li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="../index.html">Homepage</a></li>
                <li class="nav-item"><a class="nav-link active" href="../gebruikerslessen/lessen.php">Lessen</a></li>
                <li class="nav-item"><a class="nav-link" href="../dashboard/dashboard.html">Dashboard</a></li>
            </ul>
        </div>
    </nav>

    <div class="container mt-4">
        <h3 class="mb-3">Overzicht van de lessen</h3>

        <div class="input-group mb-3">
            <input type="text" id="Filter-1" placeholder="Maximale prijs" class="form-control">
            <input type="date" id="Filter-3" class="form-control">
            <select id="Filter-2" class="btn btn-outline-secondary">
                <option value="0" selected>Oplopend</option>
                <option value="2">Aflopend</option>
            </select>
        </div>

        <table class="table table-hover" id="table-leden">
            <thead>
                <tr>
                    <th>Naam</th>
                    <th>Datum</th>
                    <th>Tijd</th>
                    <th>MinAantalPersonen</th>
                    <th>MaxAantalPersonen</th>
                    <th>lesPrijs</th>
                    <th>Beschikbaarheid</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $les) : ?>
                    <tr>
                        <td><?= htmlspecialchars($les->Naam) ?></td>
                        <td><?= date('Y-m-d', strtotime($les->Datum)) ?></td>
                        <td><?= htmlspecialchars($les->Tijd) ?></td>
                        <td><?= htmlspecialchars($les->MinAantalPersonen) ?></td>
                        <td><?= htmlspecialchars($les->MaxAantalPersonen) ?></td>
                        <td><?= number_format($les->lesPrijs, 2) ?></td>
                        <td><?= htmlspecialchars($les->Beschikbaarheid) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="lessen.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
