<?php
require_once '../config.php';

session_start();
if (!isset($_SESSION["id_utilisateur"])) {
    header("Location: ../index.php");
    exit();
}

$erreur = '';
$succes = '';

$sql_etudiants = "SELECT nom_complet FROM utilisateurs WHERE type = 'etudiant'";
$stmt_etudiants = $pdo->query($sql_etudiants);
$etudiants = $stmt_etudiants->fetchAll(PDO::FETCH_COLUMN);

$sql_matieres = "SELECT libelle_matiere FROM matieres";
$stmt_matieres = $pdo->query($sql_matieres);
$matieres = $stmt_matieres->fetchAll(PDO::FETCH_COLUMN);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom_complet = $_POST['nom_complet'];
    $matiere = $_POST['matiere'];
    $note = $_POST['note'];

    if (in_array($nom_complet, $etudiants)) {
        if (in_array($matiere, $matieres)) {
            $sql_note = "INSERT INTO notes (id_utilisateur, id_matiere, note) 
                         VALUES ((SELECT id_utilisateur FROM utilisateurs WHERE nom_complet = :nom_complet), 
                                 (SELECT id_matiere FROM matieres WHERE libelle_matiere = :matiere), 
                                 :note)";
            $stmt_note = $pdo->prepare($sql_note);
            $resultat_note = $stmt_note->execute([
                'nom_complet' => $nom_complet,
                'matiere' => $matiere,
                'note' => $note
            ]);

            if ($resultat_note) {
                $succes = "Note ajoutée avec succès pour $nom_complet.";
            } else {
                $erreur = "Une erreur est survenue lors de l'ajout de la note. Veuillez réessayer.";
            }
        } else {
            $erreur = "La matière '$matiere' n'existe pas.";
        }
    } else {
        $erreur = "Étudiant : $nom_complet n'existe pas.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter Note</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2 class="mt-4">Ajouter Note</h2>
        <?php if ($erreur) : ?>
            <p style="color: red;"><?php echo $erreur; ?></p>
        <?php endif; ?>
        <?php if ($succes) : ?>
            <p style="color: green;"><?php echo $succes; ?></p>
        <?php endif; ?>
        <form method="post" action="">
            <div class="form-group col-4">
                <label for="nom_complet">Etudiant:</label>
                <select id="nom_complet" name="nom_complet" class="form-control" required>
                    <?php foreach ($etudiants as $etudiant) : ?>
                        <option value="<?php echo $etudiant; ?>"><?php echo $etudiant; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group col-4">
                <label for="matiere">Matière:</label>
                <select id="matiere" name="matiere" class="form-control" required>
                    <?php foreach ($matieres as $matiere) : ?>
                        <option value="<?php echo $matiere; ?>"><?php echo $matiere; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group col-4">
                <label for="note">Note:</label>
                <input type="number" id="note" name="note" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Ajouter Note</button>
        </form><br>
        <a href="admin.php" class="btn btn-dark">Tableau de bord</a>
    </div>
</body>
</html>
