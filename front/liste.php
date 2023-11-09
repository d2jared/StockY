<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel= stylesheet href="liste.css">
    <title>StockY - Liste</title>
</head>
<body>

    <button><a href="ajouter_object.php">Ajouter un Objet</a></button>
    <button><a href="afficher_marque.php">Afficher les Marques</a></button>
    <button><a href="afficher_categorie.php">Afficher les Catégories</a></button>
    <?php

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "stockydeux";

    $conn = new mysqli($servername, $username, $password, $dbname);
 

    // Sélectionner toutes les données de la table "item"
    $sql = "SELECT *
    FROM item
    INNER JOIN marque ON item.id_marque = marque.id_marque
    INNER JOIN categorie ON item.id_categorie = categorie.id_categorie
    ORDER BY nom ASC";
    
    $result = $conn->query($sql);

    echo "<br><br />";
    echo "<bold>Liste des Objets : <bold><br />";
    while ($row = $result->fetch_assoc()) {
        echo "______________________________________________________<br>";
        echo "<br />";
        echo "" . $row['nom'] . "<br>";
        echo "Marque : " . $row['nom_marque'] . "<br>";
        echo "Catégorie : " . $row['nom_categorie'] . "<br>";
        echo "Quantité : " . $row['quantite'] . "<br>";
        echo "Prix Unitaire : " . $row['prix'] . " €<br>";
        echo "<br />";
        echo "<button class='btn-modif' data-id=" .$row['id'] ."'>Modifier</button>";
        echo "<button class='btn-delete' data-id=" .$row['id'] ."'>Supprimer</button>";
        echo "<br />";
        }
        ?>

    <script>
        document.querySelectorAll(".btn-delete").forEach(button => {
            button.addEventListener("click", function() {
                var itemId = this.getAttribute("data-id");
                itemId = itemId.slice(0, -1);
                // Demandez confirmation avant de supprimer
                if (confirm("Voulez-vous vraiment supprimer cet objet ?")) {
                    // Redirigez vers le script PHP pour effectuer la suppression
                    window.location.href = `supprimer_objet.php?id=${itemId}`;
                }
            });
        });
    </script>

    <script>
        document.querySelectorAll(".btn-modif").forEach(button => {
            button.addEventListener("click", function() {
                var itemId = this.getAttribute("data-id");
                itemId = itemId.slice(0, -1);
                // Demandez confirmation avant de supprimer
                if (confirm("Voulez-vous vraiment modifier cet objet ?")) {
                    // Redirigez vers le script PHP pour effectuer la suppression
                    window.location.href = `modifier_objet.php?id=${itemId}`;
                }
            });
        });
    </script>

</body>
</html>