<?php
require_once '../config.php';

$erreur = '';
$succes = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ine = $_POST['ine'];
    $nom_complet = $_POST['nom_complet'];
    $adresse = $_POST['adresse'];
    $numero_telephone = $_POST['numero_telephone'];
    $email = $_POST['email'];
    $mot_de_passe = $_POST['mot_de_passe'];

    $sql_check_INE = "SELECT id_utilisateur FROM utilisateurs WHERE email = :email";
    $stmt_check_INE = $pdo->prepare($sql_check_INE);
    $stmt_check_INE->execute(['email' => $email]);
    $email_existe = $stmt_check_INE->fetchColumn();

    if ($email_existe) {
        $erreur = "E-mail déjà utilisé. Veuillez choisir un autre E-mail.";
    } else {
        $sql = "INSERT INTO utilisateurs (ine, nom_complet, adresse, numero_telephone, email, mot_de_passe, type) 
                VALUES (:ine, :nom_complet, :adresse, :numero_telephone, :email, :mot_de_passe, 'etudiant')";
        $stmt = $pdo->prepare($sql);
        $resultat = $stmt->execute([
            'ine' => $ine,
            'nom_complet' => $nom_complet,
            'adresse' => $adresse,
            'numero_telephone' => $numero_telephone,
            'email' => $email,
            'mot_de_passe' => $mot_de_passe
        ]);

        if ($resultat) {
            $succes = "Inscription réussie.";
        } else {
            $erreur = "Une erreur est survenue lors de l'inscription. Veuillez réessayer.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 40px;
        }

        .container {
            max-width: 500px;
            margin: 0 auto;
        }

        .card {
            margin-top: 20px;
            border: none;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #007bff;
            color: #fff;
            text-align: center;
            font-weight: bold;
        }

        .card-body {
            padding: 30px;
        }

        .form-group {
            margin-bottom: 5px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .error-message {
            color: red;
        }

        .success-message {
            color: green;
        }
    </style>
</head>

<body>
    <div class="container">
    <div class="jumbotron py-3 text-center">
            <h2 class="text-dark">Sunu-Plateforme</h2>
            <p class="text-muted">Projet réalisé par le Groupe 5</p>
        </div>
        <div class="card">
            <div class="card-header">
                Inscription
            </div>
            <div class="card-body">
                <?php if ($erreur) : ?>
                    <p class="error-message"><?php echo $erreur; ?></p>
                <?php endif; ?>
                <?php if ($succes) : ?>
                    <p class="success-message"><?php echo $succes; ?></p>
                <?php endif; ?>
                <form method="post" action="">
                    <div class="form-group">
                        <input type="text" id="INE" name="ine" class="form-control" required placeholder="INE">
                    </div>
                    <div class="form-group">
                        <input type="text" id="nom_complet" name="nom_complet" class="form-control" required placeholder="Nom complet">
                    </div>
                    <div class="form-group">
                        <input type="text" id="adresse" name="adresse" class="form-control" required placeholder="Adresse">
                    </div>
                    <div class="form-group">
                        <input type="number" id="numero_telephone" name="numero_telephone" class="form-control" required placeholder="Numéro de téléphone">
                    </div>
                    <div class="form-group">
                        <input type="email" id="email" name="email" class="form-control" required placeholder="E-mail">
                    </div>
                    <div class="form-group">
                        <input type="password" id="mot_de_passe" name="mot_de_passe" class="form-control" required placeholder="Mot de passe">
                    </div>
                    <button type="submit" class="btn btn-primary">S'inscrire</button>
                </form><br>
                <a href="admin.php" class="btn btn-dark">Tableau de bord</a>
            </div>
        </div>
    </div>
</body>

</html>