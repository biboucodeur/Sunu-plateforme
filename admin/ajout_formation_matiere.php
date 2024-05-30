<?php
require_once '../config.php';

session_start();
if (!isset($_SESSION["id_utilisateur"])) {
    header("Location: ../index.php");
    exit();
}

$erreur = '';
$succes = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $libelle_formation = $_POST['libelle_formation'];
    $matieres = $_POST['matieres'];

    $sql_formation = "INSERT INTO formations (libelle_formation) VALUES (:libelle_formation)";
    $stmt_formation = $pdo->prepare($sql_formation);
    $resultat_formation = $stmt_formation->execute(['libelle_formation' => $libelle_formation]);

    if ($resultat_formation) {
        $id_formation = $pdo->lastInsertId();

        $matieres_array = explode(',', $matieres);
        foreach ($matieres_array as $matiere) {
            $sql_matiere = "INSERT INTO matieres (libelle_matiere, id_formation) VALUES (:libelle_matiere, :id_formation)";
            $stmt_matiere = $pdo->prepare($sql_matiere);
            $resultat_matiere = $stmt_matiere->execute(['libelle_matiere' => trim($matiere), 'id_formation' => $id_formation]);
        }

        if ($resultat_matiere) {
            $succes = "Formation et matières ajoutées avec succès.";
        } else {
            $erreur = "Une erreur est survenue lors de l'ajout des matières.";
        }
    } else {
        $erreur = "Une erreur est survenue lors de l'ajout de la formation.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter Formation et Matières</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2 class="mt-4">Ajouter Formation et Matières</h2>
        <?php if ($erreur) : ?>
            <p style="color: red;"><?php echo $erreur; ?></p>
        <?php endif; ?>
        <?php if ($succes) : ?>
            <p style="color: green;"><?php echo $succes; ?></p>
        <?php endif; ?>
        <form method="post" action="">
            <div class="form-group col-4">
                <label for="libelle_formation">Libellé de la formation:</label>
                <input type="text" class="form-control" id="libelle_formation" name="libelle_formation" required>
            </div>
            <div class="form-group col-4">
                <label for="matieres">Matières (séparées par des virgules):</label>
                <input type="text" class="form-control" id="matieres" name="matieres" required>
            </div>
            <button type="submit" class="btn btn-primary">Ajouter Formation et Matières</button>
        </form><br>
        <a href="admin.php" class="btn btn-dark">Tableau de bord</a>
    </div>
</body>
</html>
