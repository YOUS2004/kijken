<?php


include('DOCTYPE.php');
include('header.php');
include('nav.php');
include('Footer.php');


?>






<div class="login-container">
        <div class="login-card">
            <h2>Inloggen</h2>

           

            <form method="POST" action="">
                <div class="form-group">
                    <label for="username">Gebruikersnaam:</label>
                    <input type="text" name="username" required>
                </div>

                <div class="form-group">
                    <label for="password">Wachtwoord:</label>
                    <input type="password" name="password" required>
                </div>

                <button type="submit">Inloggen</button>
            </form>
        </div>
    </div>


    <?php

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    
    if ($username == "yous" && $password == "welkom") {
        
        $_SESSION["username"] = $username;

        
        header("Location: machine-status.php");
        exit();
    } else {
        $errorMessage = "Ongeldige gebruikersnaam of wachtwoord";
    }
}
?>
