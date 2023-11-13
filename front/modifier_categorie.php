<?php
// On se connecte à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "stockydeux";

// Vérification que l'ID de la catégorie est présent dans l'URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "Identifiant de la catégorie non spécifié.";
    exit;
}

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}

// Récupération de l'ID de l'objet à modifier depuis l'URL
$categorieId = $_GET['id'];

// Sélection des informations de l'objet à modifier
$sql = "SELECT * FROM categorie WHERE id_categorie = $categorieId";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "Aucune catégorie trouvée avec cet identifiant.";
    exit;
}

// Vérification si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des nouvelles valeurs du formulaire
    $nouveauNom = $_POST['nouveau_nom'];

    // Mise à jour des valeurs dans la base de données
    $sqlUpdate = "UPDATE categorie SET nom_categorie = '$nouveauNom' WHERE id_categorie = $categorieId";

    if ($conn->query($sqlUpdate) === TRUE) {
        // Redirection vers la page liste.php après la modification
        header("Location: afficher_categorie.php");
        exit;
    } else {
        echo "Erreur lors de la mise à jour de la catégorie : " . $conn->error;
    }
}

// Fermeture de la connexion à la base de données
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stocky - Modifier</title>
    <link rel="stylesheet" href="../back/style/edit.css">
</head>

<body>

    <div class="circles">
        <div class="circle1"></div>
        <div class="circle2"></div>
    </div>

    <form method="post" action="" class="edit">
        <h1>Modifier la Catégorie</h1>
        <label for="nouveau_nom">Nouveau Nom :</label>
        <input type="text" name="nouveau_nom" value="<?php echo $row['nom_categorie']; ?>"><br>

        <button type="submit">Mettre à jour</button>
    </form>
</body>

</html>