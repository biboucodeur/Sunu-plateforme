<?php
require_once '../config.php';

session_start();
if (!isset($_SESSION["id_utilisateur"])) {
    header("Location: ../index.php");
    exit();
}
// Récupérer la liste des étudiants inscrits
$sql = "SELECT * FROM utilisateurs WHERE type = 'etudiant'";
$stmt = $pdo->query($sql);
$etudiants = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Étudiants</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 40px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Liste des Étudiants</h2>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th>INE</th>
                    <th>Nom complet</th>
                    <th>Adresse</th>
                    <th>Numéro de téléphone</th>
                    <th>E-mail</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($etudiants as $etudiant) : ?>
                    <tr>
                        <td><?php echo $etudiant['ine']; ?></td>
                        <td><?php echo $etudiant['nom_complet']; ?></td>
                        <td><?php echo $etudiant['adresse']; ?></td>
                        <td><?php echo $etudiant['numero_telephone']; ?></td>
                        <td><?php echo $etudiant['email']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table><br>
        <a href="admin.php" class="btn btn-dark">Tableau de bord</a>
    </div>
</body>
</html>
