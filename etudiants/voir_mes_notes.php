<?php
require_once '../config.php';

session_start();

if (!isset($_SESSION['id_utilisateur'])) {
    header("Location: ../index.php");
    exit;
}

$sql_notes_etudiant = "SELECT matieres.libelle_matiere, notes.note 
                       FROM notes 
                       INNER JOIN matieres ON notes.id_matiere = matieres.id_matiere 
                       WHERE notes.id_utilisateur = :id_utilisateur";
$stmt_notes_etudiant = $pdo->prepare($sql_notes_etudiant);
$stmt_notes_etudiant->execute(['id_utilisateur' => $_SESSION['id_utilisateur']]);
$notes = $stmt_notes_etudiant->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Notes</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .jumbotron {
            background-color: #333;
        }
    </style>
</head>

<body>
    <?php include("navbar.php"); ?>
    <div class="container">
        <div class="jumbotron text-light">
            <h1 class="display-4">Mes Notes</h1>
            <p class="lead">Mes notes dans différentes matières.</p>
        </div>
        <ul class="list-group col-4 m-auto">
            <?php foreach ($notes as $note) : ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <?php echo $note['libelle_matiere']; ?>
                    <span class="badge badge-success badge-pill"><?php echo $note['note']; ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>