<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel= stylesheet href="liste.css">
    <title>StockY - Liste</title>
</head>
<body>
    <button><a href="ajouter_object.php">Ajouter un objet</a></button>
    <button><a href="ajouter_marque.php">Ajouter une marque</a></button>
    <button><a href="ajouter_categorie.php">Ajouter une catégorie</a></button>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "stocky";

    $conn = new mysqli($servername, $username, $password, $dbname);
    // ...

    // Code pour la connexion à la base de données et l'insertion de données (comme dans votre code existant)

    // Sélectionner toutes les données de la table "item"
    $sql = "SELECT * FROM item";
    $result = $conn->query($sql);

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td><br /><br /> id : " . $row['id'] . "<br /></td>";
            echo "<td> Nom :" . $row['nom'] . "<br /></td>";
            echo "<td> Marque :" . $row['marque'] . "<br /></td>";
            echo "<td> quantite :" . $row['quantite'] . "<br /></td>";
            echo "<td> prix :" . $row['prix'] . "</td>";
            echo "</tr>";
        }
        ?>
</body>
</html>