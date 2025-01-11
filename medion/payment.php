<?php
// Supposons que tu as récupéré l'id du produit dans l'URL
$product_id = $_GET['product_id']; // Exemple d'ID du produit passé dans l'URL

// Connexion à la base de données pour récupérer les informations du produit
$host = 'localhost'; 
$dbname = 'nom_de_ta_base';
$username = 'root';
$password = '';
$conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Récupérer les informations du produit par son ID
$stmt = $conn->prepare("SELECT * FROM medicaments WHERE id = :id");
$stmt->execute(['id' => $product_id]);
$product = $stmt->fetch();
?>

<!-- Afficher les détails du produit sélectionné -->
<h2>Checkout</h2>
<p>Product: <?php echo $product['nom']; ?></p>
<p>Price: $<?php echo $product['prix']; ?></p>
<img src="images/<?php echo $product['image']; ?>" alt="Product Image" />

<!-- Formulaire de paiement -->
<form action="process_payment.php" method="POST">
    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>" />
    <input type="hidden" name="product_name" value="<?php echo $product['nom']; ?>" />
    <input type="hidden" name="product_price" value="<?php echo $product['prix']; ?>" />
    
    <label for="name">Full Name:</label>
    <input type="text" id="name" name="customer_name" required /><br>

    <label for="email">Email:</label>
    <input type="email" id="email" name="customer_email" required /><br>

    <label for="payment_status">Payment Status:</label>
    <select name="payment_status" required>
        <option value="En attente">Pending</option>
        <option value="Payé">Paid</option>
    </select><br>

    <button type="submit">Submit Payment</button>
</form>
