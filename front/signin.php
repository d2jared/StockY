<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../back/style/edit.css">
    <title>Stocky - Sign-in</title>
</head>
<body>
    <div class="circles">
        <div class="circle1"></div>
        <div class="circle2"></div>
    </div>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="edit">
        <h1>Inscription</h1>
        <label for="pseudo">Pseudo :</label>
        <input type="text" name="pseudo" required><br>

        <label for="password">Mot de passe :</label>
        <input type="password" name="password" required><br>

        <button type="submit">S'inscrire</button>
        <br />
        <button class="btn-login">Se connecter</button>

    </form>

        <!-- Vérifier si le formulaire a été soumis -->
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Récupérer les données du formulaire
            $login = $_POST["pseudo"];
            $password = $_POST["password"];

            // Connexion à la base de données (modifier ces informations selon votre configuration)
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "stockydeux";

            $conn = new mysqli($servername, $username, $password, $dbname);

            // Vérifier la connexion
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            //hashage du mot de passe
            $password = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("INSERT INTO user (nom_user, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $login, $password);

            // Vérifier si le login et le mot de passe existent dans la base de données
            $sql = "SELECT * FROM user WHERE nom_user = '$login' AND password = '$password'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                // Rediriger vers la page d'accueil
                echo "vous êtes déjà inscrit";
            } else {
                $stmt->execute();
                echo "vous êtes inscrit";
                header("Location: liste.php");
            }
        }

        ?>

    <script>
        document.querySelector(".btn-login").addEventListener("click", function() {
            // Redirigez vers le script PHP de login
            window.location.href = `login.php`;
        });
    </script>
</body>
</html>