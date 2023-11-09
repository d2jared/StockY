<?php
// On se connecte à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "stockydeux";

// Vérification que l'ID de l'objet est présent dans l'URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "Identifiant de l'objet non spécifié.";
    exit;
}

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}

// Récupération de l'ID de l'objet à modifier depuis l'URL
$objectId = $_GET['id'];

// Sélection des informations de l'objet à modifier
$sql = "SELECT * FROM item WHERE id = $objectId";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "Aucun objet trouvé avec cet identifiant.";
    exit;
}

// Vérification si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des nouvelles valeurs du formulaire
    $nouveauNom = $_POST['nouveau_nom'];
    $nouvelleQuantite = $_POST['nouvelle_quantite'];
    $nouveauPrix = $_POST['nouveau_prix'];

    // Mise à jour des valeurs dans la base de données
    $sqlUpdate = "UPDATE item SET nom = '$nouveauNom', quantite = $nouvelleQuantite, prix = $nouveauPrix WHERE id = $objectId";

    if ($conn->query($sqlUpdate) === TRUE) {
        // Redirection vers la page liste.php après la modification
        header("Location: liste.php");
        exit;
    } else {
        echo "Erreur lors de la mise à jour de l'objet : " . $conn->error;
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
    <title>Modifier Objet</title>
</head>

<body>
    <h1>Modifier l'Objet</h1>
    <form method="post" action="">
        <label for="nouveau_nom">Nouveau Nom :</label>
        <input type="text" name="nouveau_nom" value="<?php echo $row['nom']; ?>"><br><br>

        <label for="nouvelle_quantite">Nouvelle Quantité :</label>
        <input type="number" name="nouvelle_quantite" value="<?php echo $row['quantite']; ?>"><br><br>

        <label for="nouveau_prix">Nouveau Prix :</label>
        <input type="number" step="0.01" name="nouveau_prix" value="<?php echo $row['prix']; ?>"><br><br>

        <input type="submit" value="Mettre à jour">
    </form>
</body>

</html>