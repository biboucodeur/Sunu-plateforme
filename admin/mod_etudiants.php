<?php
include ('../config.php');
$q = $pdo->query("SELECT * FROM utilisateurs WHERE id_utilisateur='" . $_GET["id"] . "'");

while ($row = $q->fetch(PDO::FETCH_ASSOC)) {
    $ine = $row['ine'];
    $nom_complet = $row['nom_complet'];
    $adresse = $row['adresse'];
    $email = $row['email'];
    $numero_telephone = $row['numero_telephone'];
}

if (isset($_POST['update'])) {
    $ine = $_POST['ine'];
    $nom_complet = $_POST['nom_complet'];
    $adresse = $_POST['adresse'];
    $email = $_POST['email'];
    $numero_telephone = $_POST['numero_telephone'];
   

    $r = "UPDATE utilisateurs SET ine ='$ine', nom_complet='$nom_complet', adresse='$adresse', email='$email', numero_telephone='$numero_telephone' WHERE id_utilisateur = '" . $_GET["id"] . "'";
    $pdo->exec($r);

    if ($r) {
        $success = "Etudiant modifié avec succès...";
        header('Location: modifier_informations_etudiant.php?success=1');
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MODIFIER ETUDIANT</title>
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

        h3 {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"],
        input[type="number"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 20px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>

    <?php if (isset($_GET['success']) && $_GET['success'] == 1) { ?>
        <div class="container">
            <div class="alert alert-success" role="alert">
                Etudiant ajouté avec succès
            </div>
        </div>
    <?php unset($_GET['success']);
    } ?>
    <div class="container">
        <h3>Gestion Etudiant</h3>
        <form action="" method="post">
            <div class="form-group">
                <label>INE</label>
                <input type="text" class="form-control" name="ine" value="<?php echo $ine; ?>">
            </div>

            <div class="form-group">
                <label>Prénom</label>
                <input type="text" class="form-control" name="nom_complet" value="<?php echo $nom_complet; ?>">
            </div>

            <div class="form-group">
                <label>Nom</label>
                <input type="text" class="form-control" name="adresse" value="<?php echo $adresse; ?>">
            </div>

            <div class="form-group">
                <label>E-mail</label>
                <input type="email" class="form-control" name="email" value="<?php echo $email; ?>">
            </div>

            <div class="form-group">
                <label>Téléphone</label>
                <input type="number" class="form-control" name="numero_telephone" value="<?php echo $numero_telephone; ?>">
            </div><br>
            <input type="submit" class="btn btn-primary" value="Changer" name="update"><br><br>
            <a href="admin.php" class="btn btn-dark">Tableau de bord</a>
        </form>
    </div>

</body>

</html>
