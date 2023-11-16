<?php 
//récupère les données de la table marque et les affiche dans le select
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "stockydeux";

$conn = new mysqli($servername, $username, $password, $dbname);

$sql = "SELECT nom_marque FROM marque";
$result = $conn->query($sql);

echo "<select name='nom_marque' id='nom_marque'>";
while ($row = $result->fetch_assoc()) {
    echo "<option value='" . $row['nom_marque'] . "'>" . $row['nom_marque'] . "</option>";
}
echo "</select>";
?>