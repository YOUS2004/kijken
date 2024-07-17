use function fgetcsv;
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload CSV</title>
</head>

<body>

    <h2>Upload CSV naar database</h2>
    <form action="upload.php" method="post" enctype="multipart/form-data">
        Selecteer CSV-bestand:
        <input type="file" name="file" accept=".csv">
        <input type="submit" name="submit" value="Upload">
    </form>



   
<form>
    <button type="button" onclick="window.location.href='uitloggen.php'">Logout</button>
</form>
</body>

</html>


<?php
session_start(); 

if (!isset($_SESSION['username'])) {
    header("Location: inlogs.php");
    exit();
}

$allowed_roles = ['admin', 'warehouse']; 
if (!in_array($_SESSION['role'], $allowed_roles)) {
    echo "Je hebt geen toegang tot deze pagina.";
    exit();
}


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
    while ($row = $result->fetch_assoc()) {
        $group = $row["artiekel groep"];
        echo "<p><a href='group.php?group=$group'>$group</a></p>";
    }
} else {
    echo "Geen artikelgroepen gevonden";
}

$conn->close();




?>


<?php




