<?php

// Include the connection file
include('connection.php');

// Create an instance of the Connection class
$connection = new Connection();

// Create the database if it doesn't exist
$connection->createDatabase('pharmacie');

// Select the "pharmacie" database
$connection->selectDatabase('pharmacie');

// Define a query to create the "medicaments" table
$medicamentsTableQuery = "
    CREATE TABLE IF NOT EXISTS medicaments (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nom VARCHAR(100) NOT NULL,
        description TEXT,
        prix DECIMAL(10, 2) NOT NULL,
        quantite INT NOT NULL
    )
";

// Call the createTable method to create the "medicaments" table
$connection->createTable($medicamentsTableQuery, "medicaments");

?>
