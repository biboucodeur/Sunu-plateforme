<?php

require_once '../config.php';

session_start();
if (!isset($_SESSION["id_utilisateur"])) {
    header("Location: ../index.php");
    exit();
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
    <title>Tableau de bord</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .card {
            margin-bottom: 20px;
        }

        .card-header {
            background-color: #4A21FF;
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
    </style>
</head>

<body>
    <div class="container">
        <h2 class="mt-4 mb-4">Tableau de bord, Mr. <?php echo  $etudiant['nom_complet']; ?></h2>
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-book"></i> Inscrire
                    </div>
                    <div class="card-body">
                        <img src="../img/infos.png" alt="image" class="card-img-top">
                        <a href="inscription_etudiant.php" class="text-primary" class="text-primary">Inscrire un étudiant</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-file-pdf"></i> Ajouter
                    </div>
                    <div class="card-body">
                        <img src="../img/notes_mt.png" alt="image" class="card-img-top">
                        <a href="ajout_formation_matiere.php" class="text-primary">Ajouter une formation et ses Matières</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-clipboard-list"></i> Notes
                    </div>
                    <div class="card-body">
                        <img src="../img/notes.png" alt="image" class="card-img-top">
                        <a href="ajout_notes.php" class="text-primary">Ajouter les notes d'un étudiant</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-user"></i> Etudiants
                    </div>
                    <div class="card-body">
                        <img src="../img/mdp.png" alt="image" class="card-img-top">
                        <a href="liste_etudiants.php" class="text-primary">Voir l'ensemble des étudiants inscrits</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-file-pdf"></i> Notes
                    </div>
                    <div class="card-body">
                        <img src="../img/notes_mt.png" alt="image" class="card-img-top">
                        <a href="voir_notes.php" class="text-primary">Voir les notes d'un étudiant</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-clipboard-list"></i> Modifier
                    </div>
                    <div class="card-body">
                        <img src="../img/notes.png" alt="image" class="card-img-top">
                        <a href="modifier_informations_etudiant.php" class="text-primary">Modifier les informations d'un étudiant</a>
                    </div>
                </div>
            </div>


        </div><a href="../deconnexion.php" class="btn btn-danger">Déconnexion</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
