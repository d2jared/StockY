<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StockY - Ajouter</title>
    <link rel="stylesheet" href="ajouter_object.css">
</head>
<body>
    <h1>Les Marques</h1>

    <?php
    // Connexion à la base de données
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "stockydeux";

    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // Vérifier si le formulaire a été soumis
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // Récupérer les données du formulaire
      $nom = $_POST["Nom"];

      // Vérifier la connexion à la base de données
      if ($conn->connect_error) {
      die("Erreur de connexion à la base de données : " . $conn->connect_error);
      }

        // Vérifier si la marque existe déjà
        $sql_check = "SELECT nom_marque FROM marque WHERE nom_marque = '$nom'";
        $result_check = $conn->query($sql_check);

        if ($result_check->num_rows > 0) {
            echo("La marque existe déjà.<br>");
        } else {
            // Insérer les données dans la table
            $sql = "INSERT INTO marque (nom_marque) VALUES ('$nom');";
            if ($conn->query($sql) === TRUE) {
                echo "Nouvel enregistrement ajouté avec succès.";
            } else {
                echo "Erreur lors de l'ajout de l'enregistrement : " . $conn->error;
            }
        }



      // Fermer la connexion à la base de données
      $conn->close(); 

    }
  
    ?>

    <!--On Affiche la liste des marques-->
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "stockydeux";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Sélectionner toutes les données de la table "marque"
    $sql = "SELECT * FROM marque ORDER BY nom_marque ASC";
    $result = $conn->query($sql);

    echo "<br />";

    while ($row = $result->fetch_assoc()) {
        echo "______________________________________________________<br>";
        echo "<br />";
        echo "" . $row['nom_marque'] . "<br>";
        echo "<br />";
        echo "<button class='btn-modif' data-id=" .$row['id_marque'] ."'>Modifier</button>";
        echo "<button class='btn-delete' data-id=" .$row['id_marque'] ."'>Supprimer</button>";
        echo "<br />";
        }
        ?>

    <script>
        document.querySelectorAll(".btn-delete").forEach(button => {
            button.addEventListener("click", function() {
                var marqueId = this.getAttribute("data-id");
                marqueId = marqueId.slice(0, -1);
                // Demandez confirmation avant de supprimer
                if (confirm("Voulez-vous vraiment supprimer cette marque ?")) {
                    // Redirigez vers le script PHP pour effectuer la suppression
                    window.location.href = `supprimer_marque.php?id=${marqueId}`;
                }
            });
        });
    </script>

    <script>
        document.querySelectorAll(".btn-modif").forEach(button => {
            button.addEventListener("click", function() {
                var marqueId = this.getAttribute("data-id");
                marqueId = marqueId.slice(0, -1);
                // Demandez confirmation avant de supprimer
                if (confirm("Voulez-vous vraiment modifier cette marque ?")) {
                    // Redirigez vers le script PHP pour effectuer la suppression
                    window.location.href = `modifier_marque.php?id=${marqueId}`;
                }
            });
        });
    </script>

<!--formulaire-->
<br />
<h1>Ajouter une marque</h1>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="Nom">Nom :</label>
        <input type="varchar(255)" name="Nom" required><br>

        <input type="submit" value="Nouvelle marque">
    </form>

    <br />
    <button><a href="liste.php">Retour à la liste</a></button>
    
</body>
</html>