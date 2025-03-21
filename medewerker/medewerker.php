<?php
    /**
     * We sluiten het configuratiebestand in bij de pagina
     * index.php
     */
    include('../DB/config.php');
 
    $dsn = "mysql:host=$dbHost;
            dbname=$dbName;
            charset=UTF8";
 
    /**
     * Maak een nieuw PDO-object aan zodat we een verbinding
     * kunnen maken met de mysql-server
     */
    $pdo = new PDO($dsn, $dbUser, $dbPass);
 
    /**
     * Dit is de zoekvraag voor de database zodat we
     * alle achtbanen van Europa selecteren
     */
    $sql = "SELECT  MEDEWERKER.Id
                   ,MEDEWERKER.Voornaam
                   ,MEDEWERKER.Tussenvoegsel
                   ,MEDEWERKER.Achternaam
                   ,MEDEWERKER.Nummer
                   ,MEDEWERKER.Medewerkersoort
                   
   
            FROM Medewerker AS MEDEWERKER";
   
 
    /**
     * We moeten de sql-query voorbereiden voor de PDO class
     * door middel van de method prepare
     */
    $statement = $pdo->prepare($sql);
 
    /**
     * We voeren de geprepareerde sql-query uit
     */
    $statement->execute();
 
    /**
     * We krijgen de records binnen als een indexed-array
     * met daarin objecten
     */
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
    <title>Medewerker</title>
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
                    <a class="nav-link active" href= "../dashboard/dashboard.html">Dashboard</a>
                </li>
            </ul>
        </div>
    </nav>
 <div class="container">
    <div class="row mb-1 ">
        <div class="col-2"></div>
        <div class="col-8 title"><h3>Overzicht van de Medewerker</h3></div>
        <div class="col-2"></div>
      </div>
      </div>
 
     
    
      <div class="container">
        <div class="row mb-3">
            <div class="col-2"></div>
            <div class="col-8">
              <h5>Nieuwe medewerker toevoegen
                    <a href='create.php'>
                    <i class="bi bi-plus-square-fill text-danger"></i>
                    <button type="button">+</button>
                  </a>
              </h5>
            </div>
            <div class="col-2"></div>
        </div>
    </div>

     
 
 <div class="container">
    <div class="row">
        <div class="col-2"></div>
        <div class="col-8">
          <table class="table table-hover" id="table-lessen">
              <thead>
                  <th>Voornaam</th>
                  <th>Tussenvoegsel</th>
                  <th>Achternaam</th>
                  <th>Nummer</th>
                  <th>Medewerkersoort</th>
              </thead>
              <tbody>
                  <?php foreach($result as $MedewerkerInfo) : ?>
                        <tr>
                          <td><?= $MedewerkerInfo->Voornaam ?></td>
                          <td><?= $MedewerkerInfo->Tussenvoegsel ?></td>
                          <td><?= $MedewerkerInfo->Achternaam ?></td>
                          <td><?= $MedewerkerInfo->Nummer ?></td>
                          <td><?= $MedewerkerInfo->Medewerkersoort ?></td>
                 
                        </tr>
                  <?php endforeach ?>
              </tbody>
          </table>
        </div>        
        <div class="col-2"></div>
      </div>
      </div>
 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="script.js"></script>
</body>
</html>