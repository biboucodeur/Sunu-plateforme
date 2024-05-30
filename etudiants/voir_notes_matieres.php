<?php

require_once '../config.php';

session_start();

if (!isset($_SESSION['id_utilisateur'])) {
    header("Location: ../index.php");
    exit;
}

$stmt_matieres = $pdo->prepare("SELECT id_matiere, libelle_matiere FROM matieres WHERE id_matiere IN (SELECT id_matiere FROM notes WHERE id_utilisateur = ?)");
$stmt_matieres->execute([$_SESSION['id_utilisateur']]);

$options_matiere = '';

while ($row = $stmt_matieres->fetch(PDO::FETCH_ASSOC)) {
    $options_matiere .= "<option value=\"{$row['id_matiere']}\">{$row['libelle_matiere']}</option>";
}

$notes_html = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_matiere = $_POST["id_matiere"];

    $sql_notes = "SELECT note FROM notes WHERE id_utilisateur = ? AND id_matiere = ?";
    $stmt_notes = $pdo->prepare($sql_notes);
    $stmt_notes->execute([$_SESSION['id_utilisateur'], $id_matiere]);
    $notes = $stmt_notes->fetchAll(PDO::FETCH_ASSOC);

    if ($stmt_notes->rowCount() > 0) {
        $notes_html .= "<h2>Note selectionnée </h2>";
        foreach ($notes as $note) {
            $notes_html .= "Note : " . $note['note'] . "/20" ."<br>";
        }
    } else {
        $notes_html .= "Aucune note n'a été trouvée pour la matière sélectionnée.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Afficher les notes</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
      .jumbotron{
        background-color: #ccc;
      }

        .form-group {
            margin-bottom: 20px;
        }

        button[type="submit"] {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<?php include("navbar.php"); ?>
<div class="jumbotron text-light">
    <h2 class="mb-4">Mes notes dans une matière</h2>
</div>
    
    <div class="container">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group col-4">
                <label for="id_matiere">Note</label>
                <select id="id_matiere" name="id_matiere" class="form-control">
                    <?php echo $options_matiere; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Voir notes</button>
        </form>
        <div class="mt-4">
            
           

            <ul class="list-group col-4 m-auto">
       <?php echo $notes_html; ?>

        
        </ul>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

