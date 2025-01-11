<?php
// Connexion à la base de données
$host = 'localhost'; 
$dbname = 'nom_de_ta_base';
$username = 'root';
$password = '';
$conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Récupérer les informations soumises du formulaire
$product_id = $_POST['product_id'];
$product_name = $_POST['product_name'];
$product_price = $_POST['product_price'];

// Nettoyer et valider les entrées de l'utilisateur
$customer_name = htmlspecialchars(trim($_POST['customer_name']));
$customer_email = filter_var(trim($_POST['customer_email']), FILTER_SANITIZE_EMAIL);

// Vérification si l'email est valide
if (!filter_var($customer_email, FILTER_VALIDATE_EMAIL)) {
    die("L'adresse email n'est pas valide.");
}

$payment_status = $_POST['payment_status']; // "En attente" ou "Payé"
$created_at = date('Y-m-d H:i:s'); // Date et heure actuelles

// Insérer les informations dans la table 'commandes'
$stmt = $conn->prepare("INSERT INTO commandes (product_id, product_name, product_price, customer_name, customer_email, payment_status, created_at) 
VALUES (:product_id, :product_name, :product_price, :customer_name, :customer_email, :payment_status, :created_at)");

$stmt->execute([
    'product_id' => $product_id,
    'product_name' => $product_name,
    'product_price' => $product_price,
    'customer_name' => $customer_name,
    'customer_email' => $customer_email,
    'payment_status' => $payment_status,
    'created_at' => $created_at
]);

// Si le paiement est effectué, mettez à jour le statut de la commande
if ($payment_status == 'Payé') {
    $update_stmt = $conn->prepare("UPDATE commandes SET payment_status = 'Payé' WHERE product_id = :product_id AND customer_email = :customer_email");
    $update_stmt->execute(['product_id' => $product_id, 'customer_email' => $customer_email]);
}

// Rediriger l'utilisateur vers une page de confirmation
header('Location: confirmation.php');
exit();
?>
