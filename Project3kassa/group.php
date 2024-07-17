<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voorraad per groep</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        h1 {
            margin-bottom: 20px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        .back-btn {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <button class="back-btn" onclick="goBack()">Terug</button>

    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "CashFlow";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (isset($_GET['group'])) {
        $group = $_GET['group'];

        $sql = "SELECT * FROM artiekel WHERE `artiekel groep`='$group'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<h1>Voorraad voor $group</h1>";
            echo "<table>";
            echo "<tr><th>Artikelnummer</th><th>Omschrijving</th><th>Leverancier</th><th>Eenheid</th><th>Prijs</th><th>Aantal</th></tr>";
            while($row = $result->fetch_assoc()) {
                echo "<tr><td>".$row["artiekelnummer"]."</td><td>".$row["omschrijving"]."</td><td>".$row["leverancier"]."</td><td>".$row["eenheid"]."</td><td>".$row["prijs"]."</td><td>".$row["aantal"]."</td></tr>";
            }
            echo "</table>";
        } else {
            echo "Geen voorraadgegevens gevonden voor $group";
        }
    } else {
        echo "Geen artikelgroep opgegeven";
    }

    $conn->close();
    ?>

    <script>
        function goBack() {
            window.history.back();
        }
    </script>
</body>
</html>
