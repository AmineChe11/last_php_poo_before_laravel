<?php
include('Database.php'); // Inclure la classe de connexion à la base de données
include('Medicament.php'); // Inclure la classe Medicament

// Connexion à la base de données
$database = new Database();
$conn = $database->getConnection();

// Vérifier si un id est passé dans l'URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Récupérer les détails du produit depuis la base de données
    $query = "SELECT * FROM medicaments WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Créer un objet Medicament avec les détails récupérés
    $medicament = new Medicament(
        $row['id'],
        $row['nom'],
        $row['image'],
        $row['prix'],
        $row['categorie'],
        $row['rating']
    );
} else {
    echo "Produit non trouvé.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails du produit</title>
    <link rel="stylesheet" href="styles.css"> <!-- Si tu as un fichier CSS -->
</head>
<body>
    <h1>Détails du Produit</h1>
    <div class="product-details">
        <img src="<?php echo $medicament->getImage(); ?>" alt="<?php echo $medicament->getNom(); ?>">
        <h2><?php echo $medicament->getNom(); ?></h2>
        <p>Prix: $<?php echo $medicament->getPrix(); ?></p>
        <p>Catégorie: <?php echo $medicament->getCategorie(); ?></p>
        <p>Rating: <?php echo $medicament->getRating(); ?> étoiles</p>
        
        <!-- Formulaire de paiement -->
        <form action="process-payment.php" method="post">
            <input type="hidden" name="product_id" value="<?php echo $medicament->getId(); ?>">
            <input type="hidden" name="product_name" value="<?php echo $medicament->getNom(); ?>">
            <input type="hidden" name="product_price" value="<?php echo $medicament->getPrix(); ?>">

            <label for="name">Nom :</label>
            <input type="text" name="name" required><br><br>

            <label for="email">Email :</label>
            <input type="email" name="email" required><br><br>

            <label for="credit_card">Numéro de carte de crédit :</label>
            <input type="text" name="credit_card" required><br><br>

            <button type="submit">Payer</button>
        </form>
    </div>
</body>
</html>
