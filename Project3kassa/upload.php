<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "CashFlow";
$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Verbinding met de database is mislukt: " . $conn->connect_error);
}

if(isset($_FILES["file"]["name"])){
    $file_tmp = $_FILES["file"]["tmp_name"];
    $file_type = mime_content_type($file_tmp); 
    if($file_type === 'text/csv' || $file_type === 'application/vnd.ms-excel'){
        
        $handle = fopen($file_tmp, "r");
        while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
         
            $artiekelnummer = $data[0];
            $aantal = intval($data[6]); 
            $sql_check = "SELECT * FROM artiekel WHERE artiekelnummer = '$artiekelnummer'";
            $result_check = $conn->query($sql_check);
            if ($result_check->num_rows > 0) {
             
                $row = $result_check->fetch_assoc();
                $huidig_aantal = intval($row['aantal']); 
                $nieuw_aantal = $huidig_aantal + $aantal;
                $sql_update = "UPDATE artiekel SET aantal = '$nieuw_aantal' WHERE artiekelnummer = '$artiekelnummer'";
                if ($conn->query($sql_update) === TRUE) {
                    echo "Voorraad bijgewerkt voor artikelnummer: " . $artiekelnummer . "<br>";
                } else {
                    echo "Fout bij bijwerken van voorraad: " . $conn->error . "<br>";
                }
            } else {
                echo "Artikelnummer " . $artiekelnummer . " bestaat niet in de database. Geen voorraad bijgewerkt.<br>";
            }
        }
        fclose($handle);
    } else {
        echo "Alleen CSV-bestanden zijn toegestaan.";
    }
} else {
    echo "Geen bestand geüpload.";
}

$conn->close();

?>
