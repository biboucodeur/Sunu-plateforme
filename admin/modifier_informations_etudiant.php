<?php
// Inclure le fichier de configuration de la base de données
include_once '../config.php';

session_start();
if (!isset($_SESSION["id_utilisateur"])) {
    header("Location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MODIFIER-INFO-ETUDIANTS</title>
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

        h3 {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #007bff;
            color: #fff;
        }

        tr:hover {
            background-color: #f2f2f2;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <?php if (isset($_GET['success']) && $_GET['success'] == 1) { ?>
        <div class="container">
            <div class="alert alert-success" role="alert">
                Information modifiée avec succès
            </div>
        </div>
    <?php unset($_GET['success']);
    } ?>
    <div class="container">
        <h3>Modification informations étudiants</h3>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>INE</th>
                    <th>Nom complet</th>
                    <th>Adresse</th>
                    <th>Téléphone</th>
                    <th>E-mail</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include('../config.php');
                $stmt = $pdo->query("SELECT * FROM utilisateurs WHERE type = 'etudiant'");

                while ($row = $stmt->fetch()) { ?>
                    <tr>
                        <td><?php echo $row["id_utilisateur"]; ?></td>
                        <td><?php echo $row["ine"]; ?></td>
                        <td><?php echo $row["nom_complet"]; ?></td>
                        <td><?php echo $row["adresse"]; ?></td>
                        <td><?php echo $row["numero_telephone"]; ?></td>
                        <td><?php echo $row["email"]; ?></td>
                        <td><a href="mod_etudiants.php?id=<?php echo $row['id_utilisateur']; ?>">Modifier</a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <a href="admin.php" class="btn btn-dark">Tableau de bord</a>
    </div>
</body>

</html>
