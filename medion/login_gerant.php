<?php
session_start();
$errorMsg = "";

include('connection.php');

if (isset($_POST['submit'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        $errorMsg = "Les deux champs sont requis.";
    } else {
        $connection = new Connection();
        $connection->selectDatabase('pharmacie');

        $query = "SELECT * FROM gerants WHERE email = ?";
        $stmt = $connection->conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $gerant = $result->fetch_assoc();

            // Vérification du mot de passe
            if (password_verify($password, $gerant['password'])) {
                $_SESSION['id_gerant'] = $gerant['id'];
                $_SESSION['email'] = $gerant['email'];

                // Rediriger vers la page medicaments.php après une connexion réussie
                header('Location: medicaments.php');
                exit();
            }
        }
        // Vous pouvez gérer ici la connexion échouée en affichant un message d'erreur
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Gérant - Pharmacie</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f2f2f2;
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 500px;
            margin: 100px auto;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #007bff;
            margin-bottom: 20px;
        }

        .btn-container {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .btn-container .btn {
            width: 48%;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Connexion Gérant</h2>

        <!-- Affichage du message d'erreur si nécessaire -->
        <?php if (!empty($errorMsg)): ?>
            <div class="alert alert-danger"><?php echo $errorMsg; ?></div>
        <?php endif; ?>

        <form method="post" action="login_gerant.php" autocomplete="off">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    class="form-control" 
                    placeholder="Entrez votre email" 
                    required 
                    autocomplete="new-email"
                    value=""
                >
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    class="form-control" 
                    placeholder="Entrez votre mot de passe" 
                    required 
                    autocomplete="new-password"
                    value=""
                >
            </div>

            <div class="btn-container">
                <button type="submit" name="submit" class="btn btn-success">Se connecter</button>
                <a href="add_gerant.php" class="btn btn-primary">Ajouter un Gérant</a>
            </div>
        </form>
    </div>
</body>
</html>
