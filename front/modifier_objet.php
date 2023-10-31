<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StockY - Supprimer</title>
    <link rel="stylesheet" href="modifier_object.css">
</head>
<body>
<?php
// Script pour modifier un objet de la base de données
if (isset($_GET['id'])) {
    $itemId = $_GET['id'];
    //Supprimer l'objet de la base de données
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "stockydeux";

    $conn = new mysqli($servername, $username, $password, $dbname);

    $sql = "DELETE FROM item WHERE id = $itemId";
    // Exécuter la requête de suppression
if ($conn->query($sql) === TRUE) {
} else {
    echo "Échec de la suppression de la ligne : " . $conn->error;
}}
include("ajouter_object.php");
?>
</body>