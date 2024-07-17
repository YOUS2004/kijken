<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cashflow";

$dbconn = new mysqli($servername, $username, $password, $dbname);

if ($dbconn->connect_error) {
    die("Verbinding mislukt: " . $dbconn->connect_error);
}

$query = "SELECT artiekelnummer, aantalverkocht FROM verkopen";
$result = $dbconn->query($query);

if ($result->num_rows > 0) {
    echo "<h1>Verkopen</h1>";
    echo "<div id='verkopen-table'>"; 
    echo "<table>";
    echo "<tr><th>Artiekelnummer</th><th>Aantal verkocht</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['artiekelnummer'] . "</td>";
        echo "<td>" . $row['aantalverkocht'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "</div>"; 
} else {
    echo "Geen verkopen gevonden";
}
?>


<script>
$(document).ready(function() {
    function refreshVerkopen() {
        $.ajax({
            url: "fetch_verkopen.php",
            type: "GET",
            success: function(data) {
                $("#verkopen-table").html(data); 
            }
        });
    }

   
    setInterval(refreshVerkopen, 5000);
});
</script>
