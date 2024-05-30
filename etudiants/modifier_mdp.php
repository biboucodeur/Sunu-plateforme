<?php 
require_once '../config.php';

session_start();

if (!isset($_SESSION["id_utilisateur"])) {
    header("Location: ../index.php");
    exit();
}

$stmt = $pdo->prepare("SELECT mot_de_passe FROM utilisateurs WHERE id_utilisateur = ?");
$stmt->execute([$_SESSION["id_utilisateur"]]);
$motdepasse = $stmt->fetchColumn();

$message = '';

if (isset($_POST['update'])) {
    $new_motdepasse = $_POST['new_motdepasse'];

    $stmt = $pdo->prepare("UPDATE utilisateurs SET mot_de_passe = ? WHERE id_utilisateur = ?");
    $stmt->execute([$new_motdepasse, $_SESSION["id_utilisateur"]]);

    $motdepasse = $new_motdepasse;

    $message = "Le mot de passe a été modifié avec succès";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Mot de Passe</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include("navbar.php");?>
    <div class="container">
        <h1 class="mt-4">Gestion Mot de Passe</h1>
        <?php if (!empty($message)) : ?>
            <div class="alert alert-success" role="alert">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        <form action="" method="post">
            <div class="form-group">
                <label for="motdepasse">Mot de passe actuel :</label>
                <input type="text" class="form-control" id="motdepasse" name="motdepasse" value="<?php echo $motdepasse; ?>" required>
            </div>
            <div class="form-group">
                <label for="new_motdepasse">Nouveau mot de passe :</label>
                <input type="text" class="form-control" id="new_motdepasse" name="new_motdepasse" required>
            </div>
            <button type="submit" class="btn btn-primary" name="update">Changer</button>
            <a href="plateforme.php" class="btn btn-secondary">Tableau de bord</a>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
