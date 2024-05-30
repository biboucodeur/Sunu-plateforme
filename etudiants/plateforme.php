<?php
require_once '../config.php';

session_start();

if (!isset($_SESSION['id_utilisateur'])) {
    header("Location: ../index.php");
    exit;
}


$id = $_SESSION['id_utilisateur'];
$servername = 'localhost';
$dbname = 'sunuplateforme';
$username = 'root';
$password_db = '';

try {
    $bdd = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password_db);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $bdd->prepare("SELECT * FROM utilisateurs WHERE id_utilisateur = ?");
    $stmt->execute([$id]);
    $etudiant = $stmt->fetch();
} catch (PDOException $e) {
    echo '<div class="alert alert-danger" role="alert">Erreur de connexion à la base de données : ' . $e->getMessage() . '</div>';
}

$bdd = null;
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
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .card {
            margin-bottom: 20px;
        }

        .card-header {
            background-color: #007bff;
            color: #fff;
            font-weight: bold;
        }

        .card-header i {
            font-size: 18px;
            margin-right: 10px;
        }

        .card-body a {
            color: #333;
            text-decoration: none;
        }

        .navbar {
            background-color: #007bff;
        }

        .navbar-brand,
        .navbar-nav .nav-link {
            color: #fff !important;
        }

        .navbar-nav .nav-link:hover {
            color: #fff !important;
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
        <h2 class="mt-4 mb-4">Tableau de bord, <?php echo $etudiant['nom_complet']; ?></h2>
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-info-circle"></i> Informations
                    </div>
                    <div class="card-body">
                        <img src="../img/infos.png" alt="image" class="card-img-top">
                        <a href="voir_infos.php" class="text-primary">Mes info administratives</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-book-open"></i> Matières
                    </div>
                    <div class="card-body">
                        <img src="../img/notes_mt.png" alt="image" class="card-img-top">
                        <a href="voir_notes_matieres.php" class="text-primary">Mes notes dans une matière</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-list-alt"></i> Notes
                    </div>
                    <div class="card-body">
                        <img src="../img/notes.png" alt="image" class="card-img-top">
                        <a href="voir_mes_notes.php" class="text-primary">Toutes mes notes</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-lock"></i> Mot de passe
                    </div>
                    <div class="card-body">
                        <img src="../img/mdp.png" alt="image" class="card-img-top">
                        <a href="modifier_mdp.php" class="text-primary">Modifier Mot de passe</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer py-3 bg-dark">
        <div class="container text-center">
            <h2 class="text-muted">Sunu-Plateforme</h2>
            <p class="text-muted">Biboucodeur</p>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>