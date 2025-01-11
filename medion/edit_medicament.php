<?php
// Inclure la connexion à la base de données
include('connection.php');

// Créer une connexion
$connection = new Connection();
$connection->selectDatabase('pharmacie');

// Vérifier si l'ID est passé en paramètre
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Convertir l'ID en entier

    // Récupérer les informations du médicament
    $query = "SELECT * FROM medicaments WHERE id = $id";
    $result = mysqli_query($connection->conn, $query);
    $medicament = mysqli_fetch_assoc($result);
} else {
    echo "ID du médicament non spécifié.";
    exit();
}

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'];
    $description = $_POST['description'];
    $prix = $_POST['prix'];
    $quantite = $_POST['quantite'];

    // Requête pour mettre à jour le médicament
    $updateQuery = "UPDATE medicaments SET nom='$nom', description='$description', prix='$prix', quantite='$quantite' WHERE id=$id";

    if (mysqli_query($connection->conn, $updateQuery)) {
        echo "Médicament mis à jour avec succès.";
        header("Location: medicaments.php");
        exit();
    } else {
        echo "Erreur lors de la mise à jour du médicament: " . mysqli_error($connection->conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Médicament</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-4">
        <h2 class="text-center mb-4">Modifier Médicament</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="nom" class="form-label">Nom</label>
                <input type="text" class="form-control" name="nom" value="<?php echo $medicament['nom']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" name="description" required><?php echo $medicament['description']; ?></textarea>
            </div>

            <div class="mb-3">
                <label for="prix" class="form-label">Prix</label>
                <input type="number" class="form-control" step="0.01" name="prix" value="<?php echo $medicament['prix']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="quantite" class="form-label">Quantité</label>
                <input type="number" class="form-control" name="quantite" value="<?php echo $medicament['quantite']; ?>" required>
            </div>

            <button type="submit" class="btn btn-success">Mettre à jour</button>
            <a href="medicaments.php" class="btn btn-secondary">Retour à la liste des médicaments</a>
        </form>
    </div>
</body>
</html>
