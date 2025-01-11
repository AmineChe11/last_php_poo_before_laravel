<?php

class Connection {

    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    public $conn;

    public function __construct() {
        // Créer la connexion
        $this->conn = mysqli_connect($this->servername, $this->username, $this->password);

        // Vérifier la connexion
        if (!$this->conn) {
            die("Connexion échouée: " . mysqli_connect_error());
        }
    }

    public function createDatabase($dbName) {
        // Créer une base de données
        $sql = "CREATE DATABASE IF NOT EXISTS $dbName";
        if (mysqli_query($this->conn, $sql)) {
            echo "Base de données '$dbName' créée ou déjà existante.<br>";
        } else {
            echo "Erreur lors de la création de la base de données: " . mysqli_error($this->conn) . "<br>";
        }
    }

    public function selectDatabase($dbName) {
        // Sélectionner la base de données
        if (!mysqli_select_db($this->conn, $dbName)) {
            die("Erreur de sélection de la base de données '$dbName': " . mysqli_error($this->conn));
        }
    }

    public function createTable($query, $tableName = "Table") {
        // Créer une table
        if (mysqli_query($this->conn, $query)) {
            echo "Table '$tableName' créée avec succès.<br>";
        } else {
            echo "Erreur lors de la création de la table '$tableName': " . mysqli_error($this->conn) . "<br>";
        }
    }

    // Méthode pour ajouter un gérant
    public function insertGerant($email, $password) {
        // Hacher le mot de passe avant de l'insérer
        $password_hache = password_hash($password, PASSWORD_DEFAULT);
        
        // Utilisation d'une requête préparée pour éviter les injections SQL
        $query = "INSERT INTO gerants (email, password) VALUES (?, ?)";
        $stmt = mysqli_prepare($this->conn, $query);
        
        // Lier les paramètres
        mysqli_stmt_bind_param($stmt, 'ss', $email, $password_hache);
        
        // Exécuter la requête
        if (mysqli_stmt_execute($stmt)) {
            echo "Gérant ajouté avec succès !<br>";
        } else {
            echo "Erreur lors de l'ajout du gérant: " . mysqli_error($this->conn) . "<br>";
        }
        
        // Fermer la requête préparée
        mysqli_stmt_close($stmt);
    }

    // Méthode pour vérifier le login du gérant
    public function verifyGerantLogin($email, $password) {
        // Utilisation d'une requête préparée pour éviter les injections SQL
        $query = "SELECT * FROM gerants WHERE email = ?";
        $stmt = mysqli_prepare($this->conn, $query);
        
        // Lier le paramètre
        mysqli_stmt_bind_param($stmt, 's', $email);
        
        // Exécuter la requête
        mysqli_stmt_execute($stmt);
        
        // Récupérer les résultats
        $result = mysqli_stmt_get_result($stmt);
        
        if (mysqli_num_rows($result) == 1) {
            // Récupérer les informations du gérant trouvé
            $row = mysqli_fetch_assoc($result);
            
            // Vérifier si le mot de passe est correct
            if (password_verify($password, $row['password'])) {
                mysqli_stmt_close($stmt);
                return true; // Connexion réussie
            } else {
                mysqli_stmt_close($stmt);
                return false; // Mot de passe incorrect
            }
        } else {
            mysqli_stmt_close($stmt);
            return false; // Aucun gérant trouvé avec cet email
        }
    }

    public function __destruct() {
        // Fermer la connexion
        if ($this->conn) {
            mysqli_close($this->conn);
        }
    }
}

?>
