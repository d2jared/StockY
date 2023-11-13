<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StockY - Ajouter</title>
    <link rel="stylesheet" href="../back/style/ajouter_object.css">
</head>

<body>
    <?php
        // Connexion à la base de données
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "stockydeux";

        $conn = new mysqli($servername, $username, $password, $dbname);
    ?>

    <div class="circles">
        <div class="circle1"></div>
        <div class="circle2"></div>
    </div>

    <!--formulaire-->
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="add_item">
        <h1>Ajouter un objet</h1>

        <input type="text" name="nom" required placeholder="Nom"><br>

        <?php 
            //récupère les données de la table marque et les affiche dans le select
            $sql = "SELECT nom_marque FROM marque";
            $result = $conn->query($sql);

            echo "<select name='nom_marque' id='nom_marque'>";
            echo "<option value='defaut'>Choisissez la Marque</option>";
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['nom_marque'] . "'>" . $row['nom_marque'] . "</option>";
            }
            echo "</select>";
            echo "<br>";
        ?>
    
        <input type="number" name="quantite" min="0" required placeholder="Quantité"><br>

        <input type="number" step="0.01" name="prix" min="0.01" required placeholder="Prix Unitaire"><br>

        <?php
            //récupère les données de la table categorie et les affiche dans le select
            $sql = "SELECT nom_categorie FROM categorie";
            $result = $conn->query($sql);

            echo "<select name='nom_categorie' id='nom_categorie'>";
            echo "<option value='defaut'>Choisissez la Categorie</option>";
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['nom_categorie'] . "'>" . $row['nom_categorie'] . "</option>";
            }
            echo "</select>";
            echo "<br>";
        ?>
            
        <button type="submit">Ajouter un Enregistrement</button>
        <button class="back">Retour à la liste</button>
    </form>

    <br />

    <?php
        // Vérifier si le formulaire a été soumis
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Récupérer les données du formulaire
            $nom = $_POST["nom"];
            // Récuperer l'id de la marque
            $sql = "SELECT id_marque FROM marque WHERE nom_marque = '" . $_POST["nom_marque"] . "'";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $id_marque = $row['id_marque'];
            $quantite = $_POST["quantite"];
            $prix = $_POST["prix"];
            // Réuperer l'id de la categorie
            $sql = "SELECT id_categorie FROM categorie WHERE nom_categorie = '" . $_POST["nom_categorie"] . "'";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $id_categorie = $row['id_categorie'];

            // Connexion à la base de données 
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "stockydeux";

            $conn = new mysqli($servername, $username, $password, $dbname);

            // Insérer les données dans la table
            $sql = "INSERT INTO item (nom, quantite, prix, id_categorie, id_marque) VALUES ('$nom', '$quantite', '$prix', '$id_categorie', '$id_marque')";

            if ($conn->query($sql) === TRUE) {
                echo "Nouvel enregistrement ajouté avec succès.";
            } else {
                echo "Erreur lors de l'ajout de l'enregistrement : " . $conn->error;
            }

            // Fermer la connexion à la base de données
            $conn->close(); 
        }
    ?> 

    <script>
        // Bouton retour à la liste
        document.querySelector(".back").addEventListener("click", function() {
            window.location.href = "liste.php";
        });
    </script>
</body>
</html>