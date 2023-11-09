<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StockY - Supprimer</title>
    <link rel="stylesheet" href="supprimer_categorie.css">
</head>
<body>
<?php
// Script pour supprimer une catégorie de la base de données
if (isset($_GET['id'])) {
    $marqueId = $_GET['id'];
    //Supprimer la catégorie de la base de données
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "stockydeux";

    $conn = new mysqli($servername, $username, $password, $dbname);

    $sql = "DELETE FROM categorie WHERE id_categorie = $marqueId";
    // Exécuter la requête de suppression
if ($conn->query($sql) === TRUE) {
} else {
    echo "Échec de la suppression de la ligne : " . $conn->error;
}


    // Redirigez l'utilisateur vers la page de catégories après la suppression
    header("Location: afficher_categorie.php");
    exit;
} else {
    // Gérez le cas où l'ID n'est pas fourni
    echo "L'ID de la catégorie n'a pas été fourni.";
}
?>
</body>