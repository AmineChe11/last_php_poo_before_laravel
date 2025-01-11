<?php
// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $role = $_POST['role']; // Récupérer le rôle sélectionné
    
    if ($role == 'gerant') {
        // Rediriger vers la page de connexion du gérant
        header('Location: login_gerant.php');
        exit();
    } elseif ($role == 'client') {
        // Rediriger vers la page d'inscription du client
        header('Location: signin.php');
        exit();
    } else {
        echo "<h1>Rôle non valide</h1>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choix du Rôle - Pharmacie</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            text-align: center;
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 350px;
        }

        h1 {
            font-size: 24px;
            color: #333;
        }

        .role-options {
            display: flex;
            justify-content: space-around;
            margin-top: 20px;
        }

        .role {
            text-align: center;
            cursor: pointer;
        }

        .role img {
            width: 60px;
            height: 60px;
        }

        .role p {
            font-size: 18px;
            margin-top: 10px;
            color: #333;
        }

        button {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #218838;
        }

        .buttons-container {
            margin-top: 30px;
        }

        .role-button {
            background-color: #007bff;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            margin: 10px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .role-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Choisissez votre rôle</h1>

        <form method="POST" action="">
            <div class="role-options">
                <div class="role">
                    <input type="radio" id="gerant" name="role" value="gerant" style="display:none;">
                    <label for="gerant">
                        <img src="https://img.icons8.com/ios/50/000000/administrator-male.png" alt="Gérant">
                        <p>Gérant</p>
                    </label>
                </div>
                <div class="role">
                    <input type="radio" id="client" name="role" value="client" style="display:none;">
                    <label for="client">
                        <img src="https://img.icons8.com/ios/50/000000/user-male.png" alt="Client">
                        <p>Client</p>
                    </label>
                </div>
            </div>

            <div class="buttons-container">
                <!-- Boutons distincts pour chaque rôle -->
                <button type="submit" class="role-button" name="gerant_button" value="gerant" 
                    style="background-color: #28a745; display: none;" id="gerant_button">
                    Accéder en tant que Gérant
                </button>
                
                <button type="submit" class="role-button" name="client_button" value="client" 
                    style="background-color: #007bff; display: none;" id="client_button">
                    Accéder en tant que Client
                </button>
            </div>
        </form>
    </div>

    <script>
        // Afficher ou masquer les boutons en fonction du rôle sélectionné
        const gerantRadio = document.getElementById('gerant');
        const clientRadio = document.getElementById('client');
        const gerantButton = document.getElementById('gerant_button');
        const clientButton = document.getElementById('client_button');

        gerantRadio.addEventListener('change', function() {
            if (this.checked) {
                gerantButton.style.display = 'inline-block';
                clientButton.style.display = 'none';
            }
        });

        clientRadio.addEventListener('change', function() {
            if (this.checked) {
                clientButton.style.display = 'inline-block';
                gerantButton.style.display = 'none';
            }
        });
    </script>

</body>
</html>
