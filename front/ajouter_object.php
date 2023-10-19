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

    <?php
    // Vérifier si le formulaire a été soumis
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // Récupérer les données du formulaire
      $nom = $_POST["Nom"];
      $marque = $_POST["Marque"];
      $quantite = $_POST["Quantite"];

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
      $sql = "CREATE TABLE IF NOT EXISTS item (
          id INT AUTO_INCREMENT PRIMARY KEY,
          nom VARCHAR(255) NOT NULL,
          marque VARCHAR(255) NOT NULL,
          quantite INT
      )";

      if ($conn->query($sql) === TRUE) {
          echo "Table 'item' créée avec succès.";
      } else {
          echo "Erreur lors de la création de la table : " . $conn->error;
      }

      // Insérer les données dans la table
      $sql = "INSERT INTO item (nom, marque, quantite) VALUES ('$nom', '$marque', $quantite)";

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
        <label for="nom">Nom :</label>
        <input type="text" name="nom" required><br>

        <label for="marque">Marque :</label>
        <input type="text" name="marque" required><br>

        <label for="quantite">Quantité :</label>
        <input type="number" name="quantite" required><br>

        <input type="submit" value="Créer la table et ajouter un enregistrement">
    </form>
    
</body>
</html>