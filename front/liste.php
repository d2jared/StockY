<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StockY - Liste</title>
</head>
<body>
    <?php
    // ...

    // Code pour la connexion à la base de données et l'insertion de données (comme dans votre code existant)

    // Sélectionner toutes les données de la table "item"
    $sql = "SELECT * FROM item";
    $result = $conn->query($sql);

    if (!$result) {
        die("Erreur dans la requête : " . $conn->error);
    }
    ?>

<?php
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['nom'] . "</td>";
            echo "<td>" . $row['marque'] . "</td>";
            echo "<td>" . $row['quantite'] . "</td>";
            echo "<td>" . $row['prix'] . "</td>";
            echo "</tr>";
        }
        ?>
</body>
</html>