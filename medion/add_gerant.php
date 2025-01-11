<?php
session_start();

$errorMsg = "";
$successMsg = "";

if (isset($_POST['submit'])) {
    include("connection.php");

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        $errorMsg = "Tous les champs sont requis.";
    } else {
        $connection = new Connection();
        $connection->selectDatabase('pharmacie');

        $query = "SELECT * FROM gerants WHERE email = ?";
        $stmt = $connection->conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $errorMsg = "Cet email est déjà utilisé.";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $query = "INSERT INTO gerants (email, password) VALUES (?, ?)";
            $stmt = $connection->conn->prepare($query);
            $stmt->bind_param("ss", $email, $hashedPassword);

            if ($stmt->execute()) {
                $successMsg = "Le gérant a été ajouté avec succès.";
                header("Location: login_gerant.php");
                exit();
            } else {
                $errorMsg = "Une erreur s'est produite lors de l'ajout du gérant.";
            }
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Gérant</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 12px;
        }
        h2 {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Ajouter un Nouveau Gérant</h2>

        <?php if ($errorMsg): ?>
            <div class="alert alert-danger"><?php echo $errorMsg; ?></div>
        <?php endif; ?>

        <?php if ($successMsg): ?>
            <div class="alert alert-success"><?php echo $successMsg; ?></div>
        <?php endif; ?>

        <form action="add_gerant.php" method="post" autocomplete="off">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Entrez un email" required autocomplete="new-email">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Entrez un mot de passe" required autocomplete="new-password">
            </div>
            <button type="submit" class="btn btn-primary" name="submit">Ajouter le Gérant</button>
        </form>
    </div>
</body>
</html>
