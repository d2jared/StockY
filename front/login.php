<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h1>Connexion</h1>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="pseudo">Pseudo :</label>
        <input type="text" name="pseudo" required><br>

        <label for="password">Mot de passe :</label>
        <input type="password" name="password" required><br>

        <input type="submit" value="Se connecter">
        <br />
        <button><a href="signin.php">S'inscrire</a></button>
    </form>

    <!-- Vérifier si le formulaire de login a été soumis -->
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Récupérer les données du formulaire
        $login = $_POST["pseudo"];
        $password = $_POST["password"];

        // Connexion à la base de données (modifier ces informations selon votre configuration)
        $servername = "localhost";
        $username = "root";
        $dbpassword = "";
        $dbname = "stockydeux";

        $conn = new mysqli($servername, $username, $dbpassword, $dbname);

        // Vérifier la connexion
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Récupérer le mot de passe hashé de la base de données
        $sql = "SELECT password FROM user WHERE nom_user = '$login'";
        $result = $conn->query($sql);

        //hash le mot de passe
        $password = password_hash($password, PASSWORD_DEFAULT);

        if ($password = $sql) {
            // Rediriger vers la page d'accueil
            echo "vous êtes connecté";
            header("Location: liste.php");
        } else {
            echo "Mauvais login ou mot de passe";
        }

    }
       
    ?>
</body>
</html>