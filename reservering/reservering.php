<?php
    include('../DB/config.php');
 
    $dsn = "mysql:host=$dbHost;
            dbname=$dbName;
            charset=UTF8";
 
    $pdo = new PDO($dsn, $dbUser, $dbPass);
 
    // Get the period filter from the URL (if provided)
    $periodFilter = isset($_GET['period']) ? $_GET['period'] : null;
 
    // SQL query base
    $sql = "SELECT RS.Id, RS.Voornaam, RS.Tussenvoegsel, RS.Achternaam, RS.Nummer, RS.Datum, RS.Tijd, RS.Reserveringstatus
            FROM Reservering AS RS";
 
    // Apply period filter
    if ($periodFilter) {
        switch ($periodFilter) {
            case '1':
                // Period 1: Jan - Mar (Month 1 to 3)
                $sql .= " WHERE MONTH(RS.Datum) IN (1, 2, 3)";
                break;
            case '2':
                // Period 2: Apr - Jun (Month 4 to 6)
                $sql .= " WHERE MONTH(RS.Datum) IN (4, 5, 6)";
                break;
            case '3':
                // Period 3: Jul - Sep (Month 7 to 9)
                $sql .= " WHERE MONTH(RS.Datum) IN (7, 8, 9)";
                break;
            case '4':
                // Period 4: Oct - Dec (Month 10 to 12)
                $sql .= " WHERE MONTH(RS.Datum) IN (10, 11, 12)";
                break;
            default:
                // No filter, show all
                break;
        }
    }
 
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
    <title>Reserveringen</title>
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
                    <a class="nav-link" href="../gebruikerslessen/lessen.php">lessen</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="../dashboard/dashboard.html">Dashboard</a>
                </li>
            </ul>
        </div>
    </nav>
 
    <div class="container">
        <div class="row mb-1">
            <div class="col-2"></div>
            <div class="col-8 title"><h3>Overzicht van de reserveringen</h3></div>
            <div class="col-2"></div>
        </div>
    </div>

    
 
    <!-- Dropdown for period filter -->
    <div class="container">
        <div class="row mb-3">
            <div class="col-2"></div>
            <div class="col-8">
                <h5>Filter reserveringen per periode</h5>
                <select id="periodFilter" class="form-control">
                    <option value="1" <?= $periodFilter == '1' ? 'selected' : '' ?>>Periode 1: Januari - Maart</option>
                    <option value="2" <?= $periodFilter == '2' ? 'selected' : '' ?>>Periode 2: April - Juni</option>
                    <option value="3" <?= $periodFilter == '3' ? 'selected' : '' ?>>Periode 3: Juli - September</option>
                    <option value="4" <?= $periodFilter == '4' ? 'selected' : '' ?>>Periode 4: Oktober - December</option>
                </select>
            </div>
            <div class="col-2"></div>
        </div>
    </div>
 
    <!-- Filter removal button -->
    <div class="container text-center my-3">
        <button id="clearFilterBtn" class="btn btn-danger">Verwijder Filter</button>
        <a href="toevoegen.php" class="btn btn-primary">Reservering toevoegen</a>
    </div>
 
    <!-- Data Table -->
    <div class="container">
        <div class="row mb-3">
            <div class="col-2"></div>
            <div class="col-8">
                <h5 id="pageTitle"><?= $periodFilter ? 'Reserveringen voor Periode ' . $periodFilter : 'Overzicht van alle reserveringen' ?></h5>
            </div>
            <div class="col-2"></div>
        </div>
    </div>
 
    <div class="container">
        <div class="row">
            <div class="col-2"></div>
            <div class="col-8">
                <?php if (empty($result)) : ?>
                    <!-- Message when no reservations are found -->
                    <div class="alert alert-warning" role="alert">
                        Er zijn geen reserveringen gevonden voor deze periode.
                    </div>
                <?php else : ?>
                    <table class="table table-hover" id="table-reservering">
                        <thead>
                            <th>Voornaam</th>
                            <th>Tussenvoegsel</th>
                            <th>Achternaam</th>
                            <th>Nummer</th>
                            <th>Datum</th>
                            <th>Tijd</th>
                            <th>Reserveringstatus</th>
                            <th>Acties</th>
                        </thead>
                        <tbody>
                            <?php foreach($result as $ReserveringInfo) : ?>
                                <tr>
                                  <td><?= htmlspecialchars($ReserveringInfo->Voornaam) ?></td>
                                  <td><?= htmlspecialchars($ReserveringInfo->Tussenvoegsel ?? '') ?></td>
                                  <td><?= htmlspecialchars($ReserveringInfo->Achternaam) ?></td>
                                  <td><?= htmlspecialchars($ReserveringInfo->Nummer) ?></td>
                                  <td><?= htmlspecialchars($ReserveringInfo->Datum) ?></td>
                                  <td><?= htmlspecialchars($ReserveringInfo->Tijd) ?></td>
                                  <td><?= htmlspecialchars($ReserveringInfo->Reserveringstatus) ?></td>
                                  <td>
                                    <a href="update.php?id=<?= $ReserveringInfo->Id ?>" class="btn btn-warning btn-sm">Reservering wijzigen</a>
                                    <a href="delete.php?id=<?= $ReserveringInfo->Id ?>" class="btn btn-danger btn-sm"
                                       onclick="return confirm('Weet je zeker dat je deze reservering wilt verwijderen?');">
                                       Reservering verwijderen
                                    </a>
                                </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>        
            <div class="col-2"></div>
        </div>
    </div>
 
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const periodFilterSelect = document.getElementById("periodFilter");
        const clearFilterBtn = document.getElementById("clearFilterBtn");
 
        // When the user selects a period, update the URL and reload the page with the selected period
        periodFilterSelect.addEventListener("change", function () {
            const selectedPeriod = periodFilterSelect.value;
 
            // Update the URL with the selected period
            const newUrl = new URL(window.location.href);
            newUrl.searchParams.set("period", selectedPeriod); // Set the 'period' parameter
            window.location.href = newUrl.toString(); // Redirect to the new URL
        });
 
        // When the user clicks the "clear filter" button, remove the period filter
        clearFilterBtn.addEventListener("click", function () {
            const newUrl = new URL(window.location.href);
            newUrl.searchParams.delete("period"); // Remove the 'period' parameter
            window.location.href = newUrl.toString(); // Redirect to the new URL without the filter
        });
    });
    </script>
 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="script.js"></script>
</body>
</html>