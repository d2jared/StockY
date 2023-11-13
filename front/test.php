<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="liste.css">
    <title>StockY - Liste</title>
</head>

<body>

    <?php
         $servername = "localhost";
         $username = "root";
         $password = "";
         $dbname = "stockydeux";
     
         $conn = new mysqli($servername, $username, $password, $dbname);
     
    ?>

    <form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="marque">Filtrer par Marque :</label>
        <select name="marque" id="marque">
            <option value="">Toutes les marques</option>
            <?php
            // Récupérer la liste des marques depuis la base de données
            $sqlMarques = "SELECT DISTINCT nom_marque FROM marque";
            $resultMarques = $conn->query($sqlMarques);

            while ($rowMarque = $resultMarques->fetch_assoc()) {
                $selected = ($_GET['marque'] == $rowMarque['nom_marque']) ? 'selected' : '';
                echo "<option value='" . $rowMarque['nom_marque'] . "' $selected>" . $rowMarque['nom_marque'] . "</option>";
            }
            ?>
        </select>

        <label for="categorie">Filtrer par Catégorie :</label>
        <select name="categorie" id="categorie">
            <option value="">Toutes les catégories</option>
            <?php
            // Récupérer la liste des catégories depuis la base de données
            $sqlCategories = "SELECT DISTINCT nom_categorie FROM categorie";
            $resultCategories = $conn->query($sqlCategories);

            while ($rowCategorie = $resultCategories->fetch_assoc()) {
                $selected = ($_GET['categorie'] == $rowCategorie['nom_categorie']) ? 'selected' : '';
                echo "<option value='" . $rowCategorie['nom_categorie'] . "' $selected>" . $rowCategorie['nom_categorie'] . "</option>";
            }
            ?>
        </select>
        
        <br/>
        <label for="prix">Filtrer par Prix :</label>
        <input type="number" name="prix_min" id="prix_min" min="0" placeholder="Prix minimum">
        <input type="number" name="prix_max" id="prix_max" min="0" placeholder="Prix maximum">

        <input type="submit" value="Filtrer">
    </form>

    <button><a href="ajouter_object.php">Ajouter un Objet</a></button>
    <button><a href="afficher_marque.php">Afficher les Marques</a></button>
    <button><a href="afficher_categorie.php">Afficher les Catégories</a></button>

    <?php
    // ... (le reste de votre code PHP pour la connexion à la base de données et la sélection des données)

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "stockydeux";

    $conn = new mysqli($servername, $username, $password, $dbname);


    // Ajouter des conditions SQL en fonction des filtres
    $sql = "SELECT *
            FROM item
            INNER JOIN marque ON item.id_marque = marque.id_marque
            INNER JOIN categorie ON item.id_categorie = categorie.id_categorie";

    if (!empty($_GET['marque'])) {
        $sql .= " WHERE nom_marque = '" . $_GET['marque'] . "'";
    }

    if (!empty($_GET['categorie'])) {
        $sql .= (empty($_GET['marque'])) ? " WHERE" : " AND";
        $sql .= " nom_categorie = '" . $_GET['categorie'] . "'";
    }

    if (!empty($_GET['prix_min'])) {
        $sql .= (empty($_GET['marque']) && empty($_GET['categorie'])) ? " WHERE" : " AND";
        $sql .= " prix >= " . $_GET['prix_min'];
    }

    if (!empty($_GET['prix_max'])) {
        $sql .= (empty($_GET['marque']) && empty($_GET['categorie']) && empty($_GET['prix_min'])) ? " WHERE" : " AND";
        $sql .= " prix <= " . $_GET['prix_max'];
    }

    $sql .= " ORDER BY nom ASC";

    $result = $conn->query($sql);

    echo "<br><br />";
    echo "<bold>Liste des Objets : <bold><br />";
    while ($row = $result->fetch_assoc()) {
        // ... (le reste de votre code pour afficher les données)
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
        // ... (votre script JavaScript pour les boutons Modifier/Supprimer)
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