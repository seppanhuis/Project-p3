<?php
// Start the session to check if the user is logged in
session_start();
 
// Check if the user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // If not logged in, redirect to the login page
    header("Location: Login/login.php");
    exit();
}
 
require_once('config/config.php'); // Include config.php which has the PDO connection
// Get the user ID from the session
$user_id = $_SESSION['user_id'];
 
// Initialize variables for storing the user data
$voornaam = $tussenvoegsel = $achternaam = $gebruikersnaam = $email = "";
 
// Fetch user details from the database
try {
    $sql = "SELECT Voornaam, Tussenvoegsel, Achternaam, Gebruikersnaam, Email, Wachtwoord FROM Gebruiker WHERE Id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':user_id', $user_id);
    $stmt->execute();
 
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user) {
        $voornaam = $user['Voornaam'];
        $tussenvoegsel = $user['Tussenvoegsel'];
        $achternaam = $user['Achternaam'];
        $gebruikersnaam = $user['Gebruikersnaam'];
        $email = $user['Email'];
        $current_password = $user['Wachtwoord']; // We will use this to compare with the new password
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
 
// Handle the form submission to update the user data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_voornaam = trim($_POST['voornaam']);
    $new_tussenvoegsel = trim($_POST['tussenvoegsel']);
    $new_achternaam = trim($_POST['achternaam']);
    $new_gebruikersnaam = trim($_POST['gebruikersnaam']);
    $new_email = trim($_POST['email']);
    $new_password = trim($_POST['password']);
 
    // Check if the password is provided and different from the current password
    if (!empty($new_password)) {
        if ($new_password !== $current_password) {
            // If the password is different, we will update it (no hashing, as requested)
            $password_to_save = $new_password;
        } else {
            $password_to_save = $current_password; // Keep the old password if the user doesn't want to change it
        }
    } else {
        $password_to_save = $current_password; // If no password is provided, keep the current password
    }
 
    try {
        // Prepare SQL query to update the user data
        $update_sql = "UPDATE Gebruiker SET
                        Voornaam = :voornaam,
                        Tussenvoegsel = :tussenvoegsel,
                        Achternaam = :achternaam,
                        Gebruikersnaam = :gebruikersnaam,
                        Email = :email,
                        Wachtwoord = :wachtwoord
                        WHERE Id = :user_id";
       
        $update_stmt = $pdo->prepare($update_sql);
        $update_stmt->bindValue(':voornaam', $new_voornaam);
        $update_stmt->bindValue(':tussenvoegsel', $new_tussenvoegsel);
        $update_stmt->bindValue(':achternaam', $new_achternaam);
        $update_stmt->bindValue(':gebruikersnaam', $new_gebruikersnaam);
        $update_stmt->bindValue(':email', $new_email);
        $update_stmt->bindValue(':wachtwoord', $password_to_save); // Save the new or current password
        $update_stmt->bindValue(':user_id', $user_id);
 
        // Execute the query to update the user data
        $update_stmt->execute();
 
        // Check if the update was successful
        if ($update_stmt->rowCount() > 0) {
            // Update session data after successful update
            $_SESSION['voornaam'] = $new_voornaam;
            $_SESSION['tussenvoegsel'] = $new_tussenvoegsel;
            $_SESSION['achternaam'] = $new_achternaam;
            $_SESSION['gebruikersnaam'] = $new_gebruikersnaam;
            $_SESSION['email'] = $new_email;
 
            // Reload the page to show the updated values
            header("Location: dashboard.php");
            exit();  // Ensure that the script stops execution after redirect
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
 
// Handle Delete Request
if (isset($_POST['delete'])) {
    try {
        // Delete related records in 'rol' table first
        $delete_roles_sql = "DELETE FROM rol WHERE GebruikerId = :user_id";
        $delete_roles_stmt = $pdo->prepare($delete_roles_sql);
        $delete_roles_stmt->bindValue(':user_id', $user_id);
        $delete_roles_stmt->execute();
 
        // Now delete the user from the 'Gebruiker' table
        $delete_user_sql = "DELETE FROM Gebruiker WHERE Id = :user_id";
        $delete_user_stmt = $pdo->prepare($delete_user_sql);
        $delete_user_stmt->bindValue(':user_id', $user_id);
        $delete_user_stmt->execute();
 
        // Destroy the session after deletion
        session_destroy();
        header("Location: Login/login.php"); // Redirect to login after deletion
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Welcome</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Navbar -->
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
                    <a class="nav-link" href="lessen.php">Lessen</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="dashboard.php">Dashboard</a>
                </li>
                <!-- Display Log In/Log Out based on session -->
                <li class="nav-item">
                    <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
                        <a class="nav-link" href="LogUit/index.php">Log Out</a>
                    <?php else: ?>
                        <a class="nav-link" href="Login/login.php">Log In</a>
                    <?php endif; ?>
                </li>
            </ul>
        </div>
    </nav>
 
    <!-- Dashboard Content -->
    <div class="container mt-5">
        <div class="row">
            <div class="col-12">
                <h3>Welcome to Your Dashboard</h3>
                <!-- Display a message if the user is not logged in -->
                <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
                    <p>Hello, <?= htmlspecialchars($_SESSION['full_name']) ?>! You are logged in.</p>
                <?php else: ?>
                    <p>You are not logged in. Some features might not be available. Please <a href="login.php">log in</a> to access all features.</p>
                <?php endif; ?>
            </div>
        </div>
 
        <!-- User Info Section (Editable) -->
        <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
        <div class="row mt-4">
            <div class="col-6 -offset-3">
                <h5>Your Account Information</h5>
                <form method="POST" action="">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Field</th>
                                <th>Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>First Name</td>
                                <td><input type="text" name="voornaam" value="<?= htmlspecialchars($voornaam ?? '', ENT_QUOTES) ?>" class="form-control" required></td>
                            </tr>
                            <tr>
                                <td>Middle Name</td>
                                <td><input type="text" name="tussenvoegsel" value="<?= htmlspecialchars($tussenvoegsel ?? '', ENT_QUOTES) ?>" class="form-control"></td>
                            </tr>
                            <tr>
                                <td>Last Name</td>
                                <td><input type="text" name="achternaam" value="<?= htmlspecialchars($achternaam ?? '', ENT_QUOTES) ?>" class="form-control" required></td>
                            </tr>
                            <tr>
                                <td>Username</td>
                                <td><input type="text" name="gebruikersnaam" value="<?= htmlspecialchars($gebruikersnaam ?? '', ENT_QUOTES) ?>" class="form-control" required></td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td><input type="email" name="email" value="<?= htmlspecialchars($email ?? '', ENT_QUOTES) ?>" class="form-control" required></td>
                            </tr>
                            <tr>
                                <td>New Password (Leave blank if you don't want to change it)</td>
                                <td><input type="password" name="password" class="form-control"></td>
                            </tr>
                        </tbody>
                    </table>
                    <button type="Submit" class="btn btn-primary">Save Changes</button>
                    <button type="submit" name="delete" class="btn btn-danger">Delete Account</button>
                </form>
            </div>
        </div>
        <?php endif; ?>
    </div>
 
    <!-- Footer -->
    <footer class="mt-5 py-4 bg-dark text-white text-center">
        <p>&copy; <?= date('Y'); ?> FitForFun. All Rights Reserved.</p>
    </footer>
 
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
 
 