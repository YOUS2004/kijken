<?php


include('DOCTYPE.php');
include('header.php');
include('nav.php');
include('Footer.php');


?>



<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("refresh:3;./home.php");
    exit();
}


?>





    <h1>Status bewerken</h1>
    
    <?php
    
    $statusBestand = 'status.txt';

    
    $apparaten = [
        'Loopband_1' => 'beschikbaar',
        'Loopband_2' => 'beschikbaar',
        'Loopband_3' => 'beschikbaar',
        'Loopband_4' => 'beschikbaar',
        'Smith machine' => 'beschikbaar',
        'Roeisimulator' => 'beschikbaar',
        'Spinner' => 'beschikbaar',
        'Cross trainer' => 'beschikbaar'
    ];

    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        foreach ($apparaten as $apparaat => $status) {
            $formulierNaam = str_replace(' ', '_', $apparaat); 
            if (isset($_POST[$formulierNaam])) {
                $nieuweStatus = $_POST[$formulierNaam];

                
                $apparaten[$apparaat] = $nieuweStatus;
            }
        }

        file_put_contents($statusBestand, json_encode($apparaten));
    }

    
    echo '<form method="post">';
    foreach ($apparaten as $apparaat => $status) {
        $formulierNaam = str_replace(' ', '_', $apparaat); 
        echo "$apparaat: 
            <select name=\"$formulierNaam\">
                <option value=\"beschikbaar\" " . ($status === 'beschikbaar' ? 'selected' : '') . ">Beschikbaar</option>
                <option value=\"bezet\" " . ($status === 'bezet' ? 'selected' : '') . ">Bezet</option>
                <option value=\"kapot\" " . ($status === 'kapot' ? 'selected' : '') . ">Kapot</option>
            </select><br>";
    }
    echo '<input type="submit" value="Opslaan">';
    echo '</form>';
    ?>

