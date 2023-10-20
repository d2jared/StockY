<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StockY - Ajouter une catégorie</title>
    <link rel="stylesheet" href="ajouter_categorie.css">
</head>
<body>

    <h1>Ajouter une catégorie</h1>

    <?php
    // Vérifier si le formulaire a été soumis
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // Récupérer les données du formulaire
      $nom = $_POST["Nom"];
      $ranger = $_POST["Ranger"];

      // Connexion à la base de données (modifier ces informations selon votre configuration)
      $servername = "localhost";
      $username = "root";
      $password = "";
      $dbname = "stocky";

      $conn = new mysqli($servername, $username, $password, $dbname);


      // Vérifier la connexion à la base de données
      if ($conn->connect_error) {
          die("Erreur de connexion à la base de données : " . $conn->connect_error);
      }

      // Créer la table "item" si elle n'existe pas
      $sql = "CREATE TABLE IF NOT EXISTS categorie (
          id INT AUTO_INCREMENT PRIMARY KEY,
          nom VARCHAR(255) NOT NULL,
          quantite INT,
          prix INT
          );";

      if ($conn->query($sql) === TRUE) {
          echo "Table 'item' créée avec succès.";
      } else {
          echo "Erreur lors de la création de la table : " . $conn->error;
      }

      // Insérer les données dans la table
      $sql = "INSERT INTO item (nom, marque, quantite, prix) VALUES ('$nom', '$marque', $quantite, $prix);";

      if ($conn->query($sql) === TRUE) {
          echo "Nouvel enregistrement ajouté avec succès.";
      } else {
          echo "Erreur lors de l'ajout de l'enregistrement : " . $conn->error;
      }

      // Fermer la connexion à la base de données
      $conn->close(); 

    }
  
    ?>

<!--formulaire-->
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="Nom">Nom :</label>
        <input type="text" name="Nom" required><br>

        <label for="Marque">Marque :</label>
        <input type="text" name="Marque" required><br>

        <label for="Quantite">Quantité :</label>
        <input type="number" name="Quantite" required><br>

        <label for="Prix">Prix :</label>
        <input type="number" name="Prix" required><br>

        <input type="submit" value="Créer la table et ajouter un enregistrement">
    </form>

</body>
</html>