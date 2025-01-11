<?php
include('connection.php');

// Créer une connexion
$connection = new Connection();
$connection->selectDatabase('pharmacie');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les données du formulaire et échapper les valeurs pour éviter les injections SQL
    $nom = mysqli_real_escape_string($connection->conn, $_POST['nom']);
    $description = mysqli_real_escape_string($connection->conn, $_POST['description']);
    $prix = mysqli_real_escape_string($connection->conn, $_POST['prix']);
    $quantite = mysqli_real_escape_string($connection->conn, $_POST['quantite']);

    // Préparer la requête d'insertion (pas besoin d'inclure l'id)
    $query = "INSERT INTO medicaments (nom, description, prix, quantite) VALUES ('$nom', '$description', $prix, $quantite)";

    // Exécuter la requête
    if (mysqli_query($connection->conn, $query)) {
        echo "Médicament ajouté avec succès.";
    } else {
        echo "Erreur : " . mysqli_error($connection->conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Médicament</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-4">
        <h2>Ajouter un Médicament</h2>
        <form action="add_medicament.php" method="POST">
            <div class="mb-3">
                <label for="nom" class="form-label">Nom</label>
                <input type="text" class="form-control" id="nom" name="nom" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
            </div>
            <div class="mb-3">
                <label for="prix" class="form-label">Prix</label>
                <input type="number" class="form-control" id="prix" name="prix" step="0.01" required>
            </div>
            <div class="mb-3">
                <label for="quantite" class="form-label">Quantité</label>
                <input type="number" class="form-control" id="quantite" name="quantite" required>
            </div>
            <button type="submit" class="btn btn-success">Ajouter</button>
            <a href="medicaments.php" class="btn btn-secondary">Retour</a>
        </form>
    </div>
</body>
</html>
