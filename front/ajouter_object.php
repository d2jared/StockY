<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StockY - Ajouter</title>
    <link rel="stylesheet" href="ajouter_object.css">
</head>
<body>
    <h1>Ajouter un objet</h1>
    
    <!--formulaire-->
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <label for="nom">Nom :</label>
            <input type="text" name="nom" required><br>

            <label for="nom_marque">Marque :</label>
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
        echo "<option value='defaut'>Choisissez la marque</option>";
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['nom_marque'] . "'>" . $row['nom_marque'] . "</option>";
        }
        echo "</select>";
        echo "<br>";
        ?>
    
            <label for="quantite">Quantité :</label>
            <input type="number" name="quantite" required><br>
    
            <label for="prix">Prix :</label>
            <input type="number" name="prix" required><br>

            <label for="nom_categorie">Catégorie :</label>
            <?php
            //récupère les données de la table categorie et les affiche dans le select
            $sql = "SELECT nom_categorie FROM categorie";
            $result = $conn->query($sql);

            echo "<select name='nom_categorie' id='nom_categorie'>";
            echo "<option value='defaut'>Choisissez la categorie</option>";
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['nom_categorie'] . "'>" . $row['nom_categorie'] . "</option>";
            }
            echo "</select>";
            echo "<br>";
        ?>
            
    
            <input type="submit" value="ajouter un enregistrement">
        </form>

        <br />
        <button><a href="liste.php">Retour à la liste</a></button>

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

      // Connexion à la base de données (modifier ces informations selon votre configuration)
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

    
</body>
</html>