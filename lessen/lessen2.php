<?php
    include('../DB/config.php');

    $dsn = "mysql:host=$dbHost;dbname=$dbName;charset=UTF8";

    $pdo = new PDO($dsn, $dbUser, $dbPass);

    $sql = "SELECT  LES.Id
                   ,LES.Naam
                   ,LES.Datum
                   ,LES.Tijd
                   ,LES.MinAantalPersonen
                   ,LES.MaxAantalPersonen
                   ,LES.Beschikbaarheid
            FROM Les AS LES";

    $statement = $pdo->prepare($sql);
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Farro:wght@300;400;500;700&family=Luckiest+Guy&family=Passion+One:wght@400;700;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Lessen</title>
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
                    <a class="nav-link" href="../lessen.php">Lessen</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="../dashboard/dashboard.html">Dashboard</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="row mb-1">
        <div class="col-2"></div>
        <div class="col-8 title">
            <h3>Overzicht van de lessen</h3>
        </div>
        <div class="col-2"></div>
    </div>

    <div class="row mb-3">
        <div class="col-2"></div>
        <div class="col-8">
            <h5>Nieuw les toevoegen
                <a href="create.php">
                    <i class="bi bi-plus-square-fill text-danger"></i>
                </a>
            </h5>
        </div>
        <div class="col-2"></div>
    </div>

    <div class="row">
        <div class="col-2"></div>
        <div class="col-8">
            <table class="table table-hover" id="table-lessen">
                <thead>
                    <tr>
                        <th>Naam</th>
                        <th>Datum</th>
                        <th>Tijd</th>
                        <th>MinAantalPersonen</th>
                        <th>MaxAantalPersonen</th>
                        <th>Beschikbaarheid</th>
                        <th>Acties</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($result as $LessenInfo) : ?>
                        <tr>
                            <td><?= $LessenInfo->Naam ?></td>
                            <td><?= $LessenInfo->Datum ?></td>
                            <td><?= $LessenInfo->Tijd ?></td>
                            <td><?= $LessenInfo->MinAantalPersonen ?></td>
                            <td><?= $LessenInfo->MaxAantalPersonen ?></td>
                            <td><?= $LessenInfo->Beschikbaarheid ?></td>
                            <td>
                                <a href="update.php?id=<?= $LessenInfo->Id ?>" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                                <a href="delete.php?id=<?= $LessenInfo->Id ?>" class="btn btn-danger btn-sm" onclick="return confirm('Weet je zeker dat je deze les wilt verwijderen?');">
                                    <i class="bi bi-trash-fill"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
        <div class="col-2"></div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="script.js"></script>
</body>
</html>
