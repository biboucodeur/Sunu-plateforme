<?php
require_once '../config.php';

session_start();

if (!isset($_SESSION['id_utilisateur'])) {
    header("Location: ../index.php");
    exit;
}

// Récupérer les informations de l'étudiant à partir de la base de données en utilisant son email
$sql_info_etudiant = "SELECT * FROM utilisateurs WHERE id_utilisateur = :id_utilisateur";
$stmt_info_etudiant = $pdo->prepare($sql_info_etudiant);
$stmt_info_etudiant->execute(['id_utilisateur' => $_SESSION['id_utilisateur']]);
$etudiant = $stmt_info_etudiant->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord - Sunu-Plateforme</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #F4F4F4;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .jumbotron {
            background-color: #333;
            color: #fff;
        }

        .jumbotron i {
            font-size: 18px;
            margin-right: 10px;
        }

        .footer {
            background-color: #343a40;
            color: #fff;
            position: relative;
            bottom: 0;
            width: 100%;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <?php include("navbar.php"); ?>
    <div class="container">
        <div class="jumbotron">
            <h2 class="display-4">Mes Informations</h2>
            <hr class="my-4">
            <p><i class="fas fa-id-card"></i> <strong>INE :</strong> <?php echo $etudiant['ine']; ?></p>
            <p><i class="fas fa-user"></i> <strong>Nom complet:</strong> <?php echo $etudiant['nom_complet']; ?></p>
            <p><i class="fas fa-envelope"></i> <strong>Adresse Email :</strong> <?php echo $etudiant['email']; ?></p>
            <p><i class="fas fa-map-marker-alt"></i> <strong>Adresse :</strong> <?php echo $etudiant['adresse']; ?></p>
            <p><i class="fas fa-phone"></i> <strong>Numéro de Téléphone :</strong> <?php echo $etudiant['numero_telephone']; ?></p>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
