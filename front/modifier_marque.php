<?php
// On se connecte à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "stockydeux";

// Vérification que l'ID de la marque est présent dans l'URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "Identifiant de la marque non spécifié.";
    exit;
}

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}

// Récupération de l'ID de la marque à modifier depuis l'URL
$marqueId = $_GET['id'];

// Sélection des informations de la marque à modifier
$sql = "SELECT * FROM marque WHERE id_marque = $marqueId";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "Aucune marque trouvée avec cet identifiant.";
    exit;
}

// Vérification si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des nouvelles valeurs du formulaire
    $nouveauNom = $_POST['nouveau_nom'];

    // Mise à jour des valeurs dans la base de données
    $sqlUpdate = "UPDATE marque SET nom_marque = '$nouveauNom' WHERE id_marque = $marqueId";

    if ($conn->query($sqlUpdate) === TRUE) {
        // Redirection vers la page liste.php après la modification
        header("Location: afficher_marque.php");
        exit;
    } else {
        echo "Erreur lors de la mise à jour de la marque : " . $conn->error;
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
        <h1>Modifier la Marque</h1>
        <label for="nouveau_nom">Nouveau Nom :</label>
        <input type="text" name="nouveau_nom" value="<?php echo $row['nom_marque']; ?>"><br>

        <button type="submit">Mettre à jour</button>
    </form>
</body>

</html>