<?php
// Inclure la connexion à la base de données
include('connection.php');

// Créer une connexion
$connection = new Connection();
$connection->selectDatabase('pharmacie');

// Récupérer tous les médicaments
$query = "SELECT * FROM medicaments";
$result = mysqli_query($connection->conn, $query);

// Définir les en-têtes pour le téléchargement du fichier CSV
header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename="medicaments.csv"');

// Ouvrir le flux pour écrire dans le fichier CSV
$output = fopen('php://output', 'w');

// Écrire l'en-tête des colonnes dans le fichier CSV
fputcsv($output, array('ID', 'Nom', 'Description', 'Prix', 'Quantité'));

// Écrire les données des médicaments dans le fichier CSV
while ($row = mysqli_fetch_assoc($result)) {
    fputcsv($output, $row);
}

// Fermer le flux
fclose($output);
?>
