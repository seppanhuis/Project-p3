<?php
try {
    // Include configuration file
    include('Config/config.php');
    
    $dsn = "mysql:host=$dbHost;dbname=$dbName;charset=UTF8";
    
    // Create PDO object to connect to the MySQL server
    $pdo = new PDO($dsn, $dbUser, $dbPass);

    // Set error mode to exception for better error handling
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // SQL query to select all relevant fields
    $sql = "SELECT
            g.Id AS GebruikerId,
            g.Voornaam,
            g.Tussenvoegsel,
            g.Achternaam,
            g.Gebruikersnaam,
            g.Email,
            g.Wachtwoord,
            g.IsIngelogd,
            g.Uitgelogd,
            g.Opmerking AS GebruikerOpmerking,
            g.DatumAangemaakt,
            g.DatumGewijzigd,

            /* Data Van de Rol Tabel */

            r.Id AS RolId,
            r.Naam AS RolNaam,
            r.IsActief AS RolIsActief,
            r.Opmerking AS RolOpmerking
        FROM            
            Gebruiker as g
        INNER JOIN
            Rol as r
        ON
            g.Id = r.GebruikerId";
    
    // Prepare the SQL query
    $statement = $pdo->prepare($sql);
    
    // Execute the prepared statement
    $statement->execute();
    
    // Fetch all results as objects
    $result = $statement->fetchAll(PDO::FETCH_OBJ);
    
} catch (PDOException $e) {
    print(`An Error Has Happened`);
    
    // Add a delay before redirecting (e.g., 5 seconds)
    sleep(5); // Adjust the number of seconds as needed
    
    // Redirect to another website after the delay
    //header('Refresh:4; url=https://www.google.com');
    //exit(); // Ensure the script stops executing after the redirect
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Farro:wght@300;400;500;700&family=Luckiest+Guy&family=Passion+One:wght@400;700;900&display=swap"
        rel="stylesheet">
    <title>Leden</title>
    <link rel="stylesheet" href="style.css">
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
        <div class="col-12 title"><h3>Overzicht van de leden</h3></div>
    </div>
 
    <div class="row">
        <div class="col-12">
          <table class="table table-hover" id="table-lessen">
              <thead>
                  <tr>
                      <th>GebruikerId</th>
                      <th>Voornaam</th>
                      <th>Tussenvoegsel</th>
                      <th>Achternaam</th>
                      <th>Gebruikersnaam</th>
                      <th>Email</th>
                      <th>Wachtwoord</th>
                      <th>Is Ingelogd</th>
                      <th>Uitgelogd</th>
                      <th>Gebruiker Opmerking</th>
                      <th>RolId</th>
                      <th>Rol Naam</th>
                      <th>Rol Is Actief</th>
                      <th>Rol Opmerking</th>
                  </tr>
              </thead>
              <tbody>
                  <?php foreach ($result as $User): ?>
                  <tr>
                      <td><?= $User->GebruikerId ?></td>
                      <td><?= $User->Voornaam ?></td>
                      <td><?= $User->Tussenvoegsel ?></td>
                      <td><?= $User->Achternaam ?></td>
                      <td><?= $User->Gebruikersnaam ?></td>
                      <td><?= $User->Email?></td>
                      <td><?= $User->Wachtwoord ?></td>
                      <td><?= $User->IsIngelogd ? 'Yes' : 'No' ?></td>
                      <td><?= $User->Uitgelogd ?></td>
                      <td><?= $User->GebruikerOpmerking ?></td>
                      <td><?= $User->RolId ?></td>
                      <td><?= $User->RolNaam ?></td>
                      <td><?= $User->RolIsActief ? 'Active' : 'Inactive' ?></td>
                      <td><?= $User->RolOpmerking ?></td>
                  </tr>
                  <?php endforeach; ?>
              </tbody>
          </table>
        </div>        
    </div>
 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="script.js"></script>
</body>
</html>
