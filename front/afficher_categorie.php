<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StockY - Catégories</title>
    <link rel="stylesheet" href="../back/style/affichage.css">
</head>
<body>
    <div class="circles">
        <div class="circle1"></div>
        <div class="circle2"></div>
    </div>
<div class="all">
    <div class="options">
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="add">
            <h1>Ajouter une catégorie</h1>
            <label for="Nom">Nom :</label>
            <input type="text" name="Nom" required><br>

            <button type="submit">Nouvelle Catégorie</button>
        </form>
        <div class="boutons">
        <button class="liste">Retour à la liste</button>
    </div>
    </div>

    <div class="container">
    <div class="title">
    <h1>Les Catégories</h1>
    </div>

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
      $Nom = $_POST["Nom"];


      // Vérifier la connexion à la base de données
      if ($conn->connect_error) {
          die("Erreur de connexion à la base de données : " . $conn->connect_error);
      }
      
      // Vérifier si la catégorie existe déjà
      $sql_check = "SELECT nom_categorie FROM categorie WHERE nom_categorie = '$Nom'";
      $result_check = $conn->query($sql_check);

      if ($result_check->num_rows > 0) {
          echo("La catégorie existe déjà.<br>");
      } else {
        $sql = "INSERT INTO categorie (nom_categorie) VALUES ('$Nom');";

        if ($conn->query($sql) === TRUE) {
            echo "Nouvel enregistrement ajouté avec succès.<br>";
        } else {
            echo "Erreur lors de l'ajout de l'enregistrement : " . $conn->error;
        }
      }

      // Fermer la connexion à la base de données
      $conn->close(); 

    }
  
    ?>

<!--On affiche la liste des catégories-->
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "stockydeux";

$conn = new mysqli($servername, $username, $password, $dbname);

// Sélectionner toutes les données de la table "categorie"
$sql = "SELECT * FROM categorie ORDER BY nom_categorie ASC";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    echo "<div class='item'>";
    echo "<h2>" . $row['nom_categorie'] . "</h2>";
    echo "<div class='logo'>";
    echo "<button class='btn-modif' data-id=" .$row['id_categorie'] ."'><img src='../back/img/edit.svg' alt='edit_svg' /></button>";
    echo "<button class='btn-delete' data-id=" .$row['id_categorie'] ."'><img src='../back/img/delete.svg' alt='delete_svg' /></button>";
    echo "</div>";
    echo "</div>";
    }
    ?>
    </div>

    <script>
        document.querySelectorAll(".btn-delete").forEach(button => {
            button.addEventListener("click", function() {
                var itemId = this.getAttribute("data-id");
                itemId = itemId.slice(0, -1);
                // Demandez confirmation avant de supprimer
                if (confirm("Voulez-vous vraiment supprimer cet objet ?")) {
                    // Redirigez vers le script PHP pour effectuer la suppression
                    window.location.href = `supprimer_categorie.php?id=${itemId}`;
                }
            });
        });
    </script>

    <script>
        document.querySelectorAll(".btn-modif").forEach(button => {
            button.addEventListener("click", function() {
                var itemId = this.getAttribute("data-id");
                itemId = itemId.slice(0, -1);
                // Redirigez vers le script PHP pour effectuer la suppression
                window.location.href = `modifier_categorie.php?id=${itemId}`;
            });
        });
    </script>

    <script>
        document.querySelector(".liste").addEventListener("click", function() {
            // Redirigez vers le script PHP pour effectuer l'ajout
            window.location.href = `liste.php`;
        });
    </script>


</div>
</body>
</html>