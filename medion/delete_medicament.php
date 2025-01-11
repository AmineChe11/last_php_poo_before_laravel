<?php
// Inclure la connexion à la base de données
include('connection.php');

// Créer une connexion
$connection = new Connection();
$connection->selectDatabase('pharmacie');

// Vérifier si l'ID est passé en paramètre
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Convertir l'ID en entier pour éviter les injections SQL

    // Requête pour supprimer le médicament
    $query = "DELETE FROM medicaments WHERE id = $id";

    if (mysqli_query($connection->conn, $query)) {
        echo "Médicament supprimé avec succès.";
    } else {
        echo "Erreur lors de la suppression du médicament: " . mysqli_error($connection->conn);
    }
} else {
    echo "ID du médicament non spécifié.";
}

// Rediriger vers la liste des médicaments après la suppression
header("Location: medicaments.php");
exit();
?>