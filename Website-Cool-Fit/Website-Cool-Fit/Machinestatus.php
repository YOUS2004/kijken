<?php


include('DOCTYPE.php');
include('header.php');
include('nav.php');
include('Footer.php');


?>






    <h1>Status weergeven</h1>

    <?php
   
    $statusBestand = 'status.txt';

  
    if (file_exists($statusBestand)) {
        
        $statusInhoud = file_get_contents($statusBestand);
        $apparaten = json_decode($statusInhoud, true);

        if (!isset($apparaten['Loopband'])) {
            $apparaten['Loopband'] = 'beschikbaar';
        }

        foreach ($apparaten as $apparaat => $status) {
            if ($status !== 'kapot') {
                echo "$apparaat: " . $status . "<br>";
            }
        }
    } else {
        echo "Statusbestand niet gevonden.";
    }
    ?>



