<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="stylesheet" href="../back/style/liste.css">
    <link href="../node_modules/nouislider/dist/nouislider.css" rel="stylesheet">
    <script src="../node_modules/nouislider/dist/nouislider.js"></script>
    <link href="../back/style/test.css" rel="stylesheet">
    <title>StockY - Liste</title>
</head>

<body>
    <div class="circles">
        <div class="circle1"></div>
        <div class="circle2"></div>
    </div>
<div class="all">
    <?php
        // Connexion à la base de données
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "stockydeux";
     
        $conn = new mysqli($servername, $username, $password, $dbname);
    ?>
<div class="options">
    <div class="boutons">
        <button class='btn-add'>Ajouter un Objet</button>
        <button class='btn-marque'>Afficher les Marques</button>
        <button class='btn-categorie'>Afficher les Catégories</button>
    </div>
    <form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="filtre">
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
        <br/>

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
        <br>
        <div class="slider-styled" id="slider-round"></div>
        <br>
        <input type="number" name="prix_min" id="prix_min" min="0.01" placeholder="Prix minimum" step="0.01">
        <input type="number" name="prix_max" id="prix_max" min="0.01" placeholder="Prix maximum" step="0.01">
        <br/>

        <button type="submit">Filtrer</button>
    </form>

    
</div>
    <?php
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

    echo "<div class='container'>";
    echo "<div class='title'>";
    echo "<U><h1>Liste des Objets : </h1></U>";
    echo "</div>";
    while ($row = $result->fetch_assoc()) {
        echo "<div class='item'>";
        echo "<div class='name'>";
        echo "<h2>" . $row['nom'] . "</h2>";
        echo "</div>";
        echo "<div class='item-info'>";
        echo "<div class='detail'>";

        echo "<p1>Marque : </p1><p2>" . $row['nom_marque'] . "</p2><br>";
        echo "<p1>Catégorie : </p1><p2>" . $row['nom_categorie'] . "</p2><br>";
        echo "<p1>Quantité : </p1><p2>" . $row['quantite'] . "</p2><br>";
        echo "<p1>Prix Unitaire : </p1><p2>" . $row['prix'] . " €</p2>";

        echo "</div>";
        echo "<div class='logo'>";
        echo "<button class='btn-modif' data-id=" .$row['id'] ."'><img src='../back/img/edit.svg' alt='edit_svg' /></button>";
        echo "<button class='btn-delete' data-id=" .$row['id'] ."'><img src='../back/img/delete.svg' alt='delete_svg' /></button>";
        echo "</div>";
        echo "</div>";
        echo "<br /></div>";
    }
    echo "</div>";
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
                // Redirigez vers le script PHP pour effectuer la modification
                window.location.href = `modifier_objet.php?id=${itemId}`;
            });
        });
    </script>

    <script>
        document.querySelector(".btn-add").addEventListener("click", function() {
            // Redirigez vers le script PHP pour effectuer l'ajout
            window.location.href = `ajouter_object.php`;
        });
    </script>

    <script>
        document.querySelector(".btn-marque").addEventListener("click", function() {
            // Redirigez vers le script PHP d'affichage des marques
            window.location.href = `afficher_marque.php`;
        });
    </script>

    <script>
        document.querySelector(".btn-categorie").addEventListener("click", function() {
            // Redirigez vers le script PHP d'affichage des catégories
            window.location.href = `afficher_categorie.php`;
        });
    </script>

    <script>
        var slider = document.getElementById('slider-round');
        var prix_minParagraphe = document.getElementById('prix_min');
        var prix_maxParagraphe = document.getElementById('prix_max');

        noUiSlider.create(slider, {
        start: [0.01, 100],
        connect: true,
        range: {
            'min': 0.01,
            'max': 100
        }
        });



        slider.noUiSlider.on('update', function (values, handle) {

            var value = values[handle];
        if (handle) {
            prix_maxParagraphe.value = value;
        } else {
            prix_minParagraphe.value = value;
        }
        });

        prix_minParagraphe.addEventListener('change', function () {
        slider.noUiSlider.set([this.value, null]);
        });

        prix_maxParagraphe.addEventListener('change', function () {
        slider.noUiSlider.set([null, this.value]);
        });
    </script>

</div>
</body>

</html>