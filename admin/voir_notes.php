<?php
require_once '../config.php';

session_start();
if (!isset($_SESSION["id_utilisateur"])) {
    header("Location: ../index.php");
    exit();
}
// Initialiser les variables pour stocker les messages d'erreur et de succès
$erreur = '';
$succes = '';
$notes = array();

// Récupérer la liste des étudiants
$sql_etudiants = "SELECT nom_complet FROM utilisateurs WHERE type = 'etudiant'";
$stmt_etudiants = $pdo->query($sql_etudiants);
$etudiants = $stmt_etudiants->fetchAll(PDO::FETCH_COLUMN);

// Récupérer la liste des matières
$sql_matieres = "SELECT libelle_matiere FROM matieres";
$stmt_matieres = $pdo->query($sql_matieres);
$matieres = $stmt_matieres->fetchAll(PDO::FETCH_COLUMN);

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer l'nom_complet de l'étudiant et la matière choisie
    $nom_complet = $_POST['nom_complet'];
    $matiere = $_POST['matiere'];

    // Vérifier si l'nom_complet de l'étudiant existe
    $sql_etudiant = "SELECT id_utilisateur FROM utilisateurs WHERE nom_complet = :nom_complet";
    $stmt_etudiant = $pdo->prepare($sql_etudiant);
    $stmt_etudiant->execute(['nom_complet' => $nom_complet]);
    $etudiant = $stmt_etudiant->fetch();

    if ($etudiant) {
        // Vérifier si la matière existe
        $sql_matiere = "SELECT id_matiere FROM matieres WHERE libelle_matiere = :matiere";
        $stmt_matiere = $pdo->prepare($sql_matiere);
        $stmt_matiere->execute(['matiere' => $matiere]);
        $matiere_resultat = $stmt_matiere->fetch();

        if ($matiere_resultat) {
            // Récupérer les notes de l'étudiant dans la matière spécifiée
            $sql_notes = "SELECT note FROM notes WHERE id_utilisateur = :id_utilisateur AND id_matiere = :id_matiere";
            $stmt_notes = $pdo->prepare($sql_notes);
            $stmt_notes->execute([
                'id_utilisateur' => $etudiant['id_utilisateur'],
                'id_matiere' => $matiere_resultat['id_matiere']
            ]);
            $notes = $stmt_notes->fetchAll(PDO::FETCH_COLUMN);

            if ($notes) {
                // Succès: afficher les notes
                $succes = "Voici les notes de $nom_complet dans la matière '$matiere':";
            } else {
                // Aucune note trouvée
                $erreur = "Aucune note trouvée pour l'étudiant $nom_complet dans la matière '$matiere'.";
            }
        } else {
            // La matière n'existe pas
            $erreur = "La matière '$matiere' n'existe pas.";
        }
    } else {
        // L'étudiant n'existe pas
        $erreur = "Étudiant avec l'nom_complet: $nom_complet n'existe pas.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voir Notes</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 40px;
        }

        .contanom_completr {
            max-width: 500px;
            margin: 0 auto;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        form {
            margin-bottom: 20px;
        }

        button {
            margin-top: 10px;
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
    <div class="contanom_completr">
        <h2>Voir Notes</h2>
        <form method="post" action="">
            <div class="form-group">
                <label for="nom_complet">Etudiant:</label>
                <select id="nom_complet" name="nom_complet" class="form-control" required>
                    <?php foreach ($etudiants as $etudiant) : ?>
                        <option value="<?php echo $etudiant; ?>"><?php echo $etudiant; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="matiere">Matière:</label>
                <select id="matiere" name="matiere" class="form-control" required>
                    <?php foreach ($matieres as $matiere) : ?>
                        <option value="<?php echo $matiere; ?>"><?php echo $matiere; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Voir Notes</button>
        </form>
        <?php if ($erreur) : ?>
            <p class="error-message"><?php echo $erreur; ?></p>
        <?php endif; ?>
        <?php if ($succes) : ?>
            <p class="success-message"><?php echo $succes; ?></p>
            <?php if ($notes) : ?>
                <ul class="list-group">
                    <?php foreach ($notes as $note) : ?>
                        <li class="list-group-item"><?php echo $note; ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        <?php endif; ?>
        <a href="admin.php" class="btn btn-dark">Tableau de bord</a>
    </div>
    
</body>
</html>
