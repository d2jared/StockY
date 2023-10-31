<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StockY - Supprimer</title>
    <link rel="stylesheet" href="supprimer_object.css">
</head>
<body>
<?php
// Script pour supprimer un objet de la base de données
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
}


    // Redirigez l'utilisateur vers la page de liste après la suppression
    header("Location: liste.php");
    exit;
} else {
    // Gérez le cas où l'ID n'est pas fourni
    echo "L'ID de l'objet n'a pas été fourni.";
}
?>
</body>
