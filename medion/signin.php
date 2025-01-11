<?php
$errorMsg = "";
$fnameValue = "";
$lnameValue = "";
$telephoneValue = "";
$villeValue = "";
$emailValue = "";
$passValue = "";
$confPassValue = "";
$successMsg = "";

include("connection.php");
$connection = new Connection();
include("clients.php");

$connection->selectDatabase("pharmacie");

if (isset($_POST['registration'])) {
    $fnameValue = $_POST['firstName'];
    $lnameValue = $_POST['lastName'];
    $telephoneValue = $_POST['telephone'];
    $villeValue = $_POST['ville'];
    $emailValue = $_POST['email'];
    $passValue = $_POST['password'];
    $confPassValue = $_POST['confpassword'];

    // Validation des champs
    if (empty($fnameValue) || empty($lnameValue) || empty($emailValue) || empty($passValue) || empty($confPassValue)) {
        $errorMsg = "All fields must be filled in.";
    } else if (strlen($passValue) < 8) {
        $errorMsg = "Password must contain at least 8 characters.";
    } else if (preg_match('/[A-Z]+/', $passValue) == 0) {
        $errorMsg = "Password must contain at least one capital letter.";
    } else if ($passValue !== $confPassValue) {
        $errorMsg = "Passwords do not match.";
    } else {
        // Créer un nouvel objet client et insérer dans la base de données
        $clients = new Clients($fnameValue, $lnameValue, $telephoneValue, $villeValue, $emailValue, $passValue);
        $clients->insertClient("clients", $connection->conn);
        $errorMsg = Clients::$errorMsg;
        $successMsg = Clients::$successMsg;

        // Si l'insertion est réussie, rediriger vers la page de connexion
        if (empty($errorMsg)) {
            header('Location: login.php'); // Redirection vers la page login.php après inscription réussie
            exit();
        }
    }
}
?>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professional Sign Up Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        /* CSS inchangé */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body, html {
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .background {
            background-image: url('img/carousel-1.jpg'); /* Remplacez par votre propre image de fond */
            background-size: cover;
            background-position: center;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: -1;
            filter: brightness(0.6);
        }

        .signup-container {
            background-color: rgba(51, 51, 51, 0.9);
            padding: 50px;
            border-radius: 12px;
            width: 600px;
            text-align: center;
            color: #ffffff;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
            animation: fadeIn 1s ease-in-out;
        }

        .signup-container h2 {
            font-size: 28px;
            margin-bottom: 20px;
            color: #ffffff;
            font-weight: bold;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .name-fields {
            display: flex;
            gap: 10px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            padding: 15px;
            border: 1px solid #444;
            border-radius: 6px;
            background-color: #555;
            color: #ffffff;
            transition: background-color 0.3s, box-shadow 0.3s;
            width: 100%;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus {
            background-color: #666;
            box-shadow: 0 0 8px rgba(0, 123, 255, 0.6);
            outline: none;
        }

        input::placeholder {
            color: #ccc;
        }

        button {
            padding: 15px;
            border: none;
            border-radius: 6px;
            background-color: #007bff;
            color: #ffffff;
            font-weight: bold;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
        }

        button:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }

        .social-icons {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 10px;
        }

        .social-icons a {
            color: #ccc;
            font-size: 1.5em;
            transition: color 0.3s, transform 0.2s;
        }

        .social-icons a:hover {
            color: #ffffff;
            transform: scale(1.1);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>

<div class="background"></div>
<div class="signup-container">
    <h2>Sign up</h2>
    <form action="" method="post">
        <?php
        if (!empty($errorMsg)) {
            echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                    <strong>$errorMsg</strong>
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                  </div>";
        }
        ?>
        <div class="name-fields">
            <input name="firstName" value="<?php echo htmlspecialchars($fnameValue); ?>" type="text" placeholder="First name">
            <input name="lastName" value="<?php echo htmlspecialchars($lnameValue); ?>" type="text" placeholder="Last name">
        </div>
        <div class="name-fields">
            <input name="telephone" value="<?php echo htmlspecialchars($telephoneValue); ?>" type="text" placeholder="Telephone">
            <input name="ville" value="<?php echo htmlspecialchars($villeValue); ?>" type="text" placeholder="Ville">
        </div>
        <input type="email" value="<?php echo htmlspecialchars($emailValue); ?>" name="email" placeholder="Email address">
        <input type="password" value="<?php echo htmlspecialchars($passValue); ?>" name="password" placeholder="Password">
        <input type="password" value="<?php echo htmlspecialchars($confPassValue); ?>" name="confpassword" placeholder="Confirm Password">
        <button name="registration" value="registration">SIGN UP</button>
        <div>
            <a href="login.php" style="display: inline-block; padding: 10px 20px; background-color: #007bff; color: white; text-decoration: none; border: none; border-radius: 5px; transition: background-color 0.3s, transform 0.2s">Log In</a>
        </div>
        <?php
        if (!empty($successMsg)) {
            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>$successMsg</strong>
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                  </div>";
        }
        ?>
    </form>

    <p>or sign up with:</p>
    <div class="social-icons">
        <a href="#"><i class="fab fa-facebook-f"></i></a>
        <a href="#"><i class="fab fa-google"></i></a>
        <a href="#"><i class="fab fa-twitter"></i></a>
        <a href="#"><i class="fab fa-github"></i></a>
    </div>
</div>

</body>
</html>
