<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./main.css"> 
    <title>Kassa</title>
   
</head>
<body>

   
<form>
    <button type="button" onclick="window.location.href='uitloggen.php'">Logout</button>
</form>
  



<div class="div">

</div>

    <h1 id="Titel" >Kassa</h1>
    <form id="item" method="POST">
        <label for="artikelnummer">Artikelnummer:</label>
        <input type="text" id="artikelnummer" name="artikelnummer" required>
        <button  type="submit" name="search">Zoeken</button>
    </form>


    <div class="numeric-keypad">
        <button onclick="addToInput('1')">1</button>
        <button onclick="addToInput('2')">2</button>
        <button onclick="addToInput('3')">3</button>
        <button onclick="addToInput('4')">4</button>
        <button onclick="addToInput('5')">5</button>
        <button onclick="addToInput('6')">6</button>
        <button onclick="addToInput('7')">7</button>
        <button onclick="addToInput('8')">8</button>
        <button onclick="addToInput('9')">9</button>
        <button onclick="addToInput('0')">0</button>
        <button onclick="clearInput()">Clear</button>
    </div>

    <script>
        function addToInput(value) {
            document.getElementById('artikelnummer').value += value;
        }

        function clearInput() {
            document.getElementById('artikelnummer').value = '';
        }
    </script>

    



    <?php
session_start(); 

if (!isset($_SESSION['username'])) {
    header("Location: inlogs.php");
    exit();
}

$allowed_roles = ['admin', 'manager', 'cashier']; 
if (!in_array($_SESSION['role'], $allowed_roles)) {
    echo "Je hebt geen toegang tot deze pagina.";
    exit();
}


?>

<form id="bedrag" method="POST">
        <label for="gegeven_bedrag">Gegeven bedrag:</label>
        <input type="text" id="gegeven_bedrag" name="gegeven_bedrag" required>
        <button type="submit" name="bereken">Bereken</button>
    </form>

    <?php



    if(isset($_POST['bereken']) && isset($_POST['gegeven_bedrag'])) {
        $gegeven_bedrag = floatval($_POST['gegeven_bedrag']);
        $totaalbedrag = 0;

        foreach ($_SESSION['winkelwagen'] as $product) {
            $totaalbedrag += $product['prijs'] * (isset($product['qty']) ? $product['qty'] : 1); 
        }

        if ($gegeven_bedrag < $totaalbedrag) {
            echo "<p>Sorry, maar dat is te weinig geld.</p>";
        } else {
            $wisselgeld = $gegeven_bedrag - $totaalbedrag;
            echo "<div class='result-container'>";
            echo "<div> <span>Te betalen:</span> €" . number_format($totaalbedrag, 2) . "</div>";
            echo "<div> <span>Ontvangen:</span> €" . number_format($gegeven_bedrag, 2) . "</div>";
            echo "<div> <span>Wisselgeld:</span> €" . number_format($wisselgeld, 2) . "</div>";
            echo "</div>";
        }
        
    }
    ?>

    <script>
        function addToInput(value) {
            document.getElementById('artikelnummer').value += value;
        }

        function clearInput() {
            document.getElementById('artikelnummer').value = '';
        }
    </script>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "CashFlow";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    

    if (!isset($_SESSION['winkelwagen'])) {
        $_SESSION['winkelwagen'] = array();
    }

    

    if(isset($_POST['search'])) {
        $artikelnummer = $_POST['artikelnummer'];
        
        $sql = "SELECT * FROM artiekel WHERE artiekelnummer='$artikelnummer'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $row['qty'] = 1; 
            $_SESSION['winkelwagen'][] = $row;
        } else {
            echo "<p>Geen product gevonden voor het opgegeven artikelnummer.</p>";
        }
    }

    if (!empty($_SESSION['winkelwagen'])) {
    
        echo "<form method='POST'>";
        echo "<button type='submit' name='betalen' class='betalen-btn'>Betalen</button>";
        echo "</form>";
        
    }  

    
    if (!empty($_SESSION['winkelwagen'])) {
        echo "<h2>Winkelwagen</h2>";
        echo "<table>";
        echo "<tr><th>Artikelnummer</th><th>Omschrijving</th><th>Prijs</th><th>Aantal</th></tr>";
        $totaalbedrag = 0;
        foreach ($_SESSION['winkelwagen'] as $key => $product) {
            echo "<tr>";
            echo "<td>".$product['artiekelnummer']."</td>";
            echo "<td>".$product['omschrijving']."</td>";
            echo "<td>".$product['prijs']."</td>";
            echo "<td>";
            echo "<form method='POST'>";
            echo "<input type='hidden' name='product_key' value='".$key."'>";
            echo "<button type='submit' name='decrease_qty' class='quantity-btn'>-</button>";
            echo "<span>".(isset($product['qty']) ? $product['qty'] : 1)."</span>"; 
            echo "<button type='submit' name='increase_qty' class='quantity-btn'>+</button>";
            echo "</form>";
            echo "</td>";
            echo "</tr>";
            $totaalbedrag += $product['prijs'] * (isset($product['qty']) ? $product['qty'] : 1); 
            $_SESSION['aantal_producten'] = $product['qty'];
        }
        
        
        echo "</table>";
        echo "<p>Totaalbedrag: €".$totaalbedrag."</p>";
        echo "<form method='POST'>";
        echo "<button type='submit' name='clear_cart' class='clear-btn'>Winkelwagen wissen</button>";
        echo "</form>";
    } else {
        echo "<p>Winkelwagen is leeg.</p>";
    }

    $conn->close();

    if(isset($_POST['increase_qty'])) {
        $key = $_POST['product_key'];
        $_SESSION['winkelwagen'][$key]['qty']++;
        header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    }

    if(isset($_POST['decrease_qty'])) {
        $key = $_POST['product_key'];
        if($_SESSION['winkelwagen'][$key]['qty'] > 1) {
            $_SESSION['winkelwagen'][$key]['qty']--;
        }
        header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    }

    if(isset($_POST['clear_cart'])) {
        unset($_SESSION['winkelwagen']);
        header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    }

    

    
    ?>
    <?php

if(isset($_POST['betalen'])) {
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    foreach ($_SESSION['winkelwagen'] as $product) {
        $artikelnummer = $product['artiekelnummer'];
        $qty = $product['qty'];

        $sql = "SELECT aantal FROM artiekel WHERE artiekelnummer='$artikelnummer'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $huidig_aantal = $row['aantal'];
            $_SESSION['huidig_aantal'] = $huidig_aantal;

            if ($qty > $huidig_aantal) {
                echo "<p>Niet genoeg voorraad beschikbaar voor product met artikelnummer: $artikelnummer</p>";
                exit(); 
            }

            $nieuw_aantal = $huidig_aantal - $qty;
            $update_sql = "UPDATE artiekel SET aantal='$nieuw_aantal' WHERE artiekelnummer='$artikelnummer'";
            $conn->query($update_sql);
        }
    }

    unset($_SESSION['winkelwagen']);

    $conn->close();

    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}
?>

<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cashflow";

$dbconn = new mysqli($servername, $username, $password, $dbname);

if ($dbconn->connect_error) {
    die("Verbinding mislukt: " . $dbconn->connect_error);
}

foreach ($_SESSION['winkelwagen'] as $product) {
    $artikelnummer = $product['artiekelnummer'];
    $Nieuw_aantal_verkopen = intval($_SESSION['aantal_producten']) + intval($_SESSION['huidig_aantal']);

    $sql = "UPDATE verkopen
            SET aantalverkocht = $Nieuw_aantal_verkopen
            WHERE artiekelnummer = $artikelnummer;";
    if (!$dbconn->query($sql)) {
        echo "Error: " . $sql . "<br>" . $dbconn->error;
    }
}

$dbconn->close();
?>








<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "CashFlow";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT DISTINCT `artiekel groep` FROM artiekel";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h1>Artikelgroepen</h1>";
    while($row = $result->fetch_assoc()) {
        $group = $row["artiekel groep"];
        echo "<div class='group-block'><a href='group.php?group=$group'>$group</a></div>";
    }
} else {
    echo "Geen artikelgroepen gevonden";
}
    
$conn->close();
?>



</body>
</html>

