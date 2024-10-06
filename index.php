<?php

require_once 'config.php';
session_start();

$erreur = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $mot_de_passe = $_POST['mot_de_passe'];

    $sql = "SELECT * FROM utilisateurs WHERE email = :email AND mot_de_passe = :mot_de_passe";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['email' => $email, 'mot_de_passe' => $mot_de_passe]);
    $utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($utilisateur) {
        $_SESSION['id_utilisateur'] = $utilisateur['id_utilisateur'];

        if ($utilisateur['type'] == 'administrateur') {
            header('Location: admin/admin.php');
            exit();
        } else {
            header('Location: etudiants/plateforme.php');
            exit();
        }
    } else {
        $erreur = "Email ou mot de passe incorrect.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sunu-plateforme</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background-color: #F4F4F4;
        }

        .container {
            margin-top: 70px;
        }

        .card {
            border-radius: 5px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        }

        .card-header {
            background-color: #007bff;
            color: #fff;
            border-bottom: none;
            border-radius: 5px 5px 0 0;
        }

        .card-body {
            background-color: #fff;
            border-radius: 0 0 15px 15px;
        }

        .form-control {
            border-radius: 5px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            border-radius: 5px;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .card-footer {
            background-color: #f8f9fa;
            border-top: none;
            border-radius: 0 0 15px 15px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="jumbotron py-3 text-center">
            <h2 class="text-dark">Sunu-Plateforme</h2>
            <p class="text-muted">Biboucodeur</p>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">
                        <h2><i class="fas fa-sign-in-alt"></i> Connexion</h2>
                    </div>
                    <div class="card-body">
                        <?php if (isset($erreur)) : ?>
                            <div class="text-danger">
                                <?php echo $erreur; ?>
                            </div>
                        <?php endif; ?>
                        <form method="post" action="">
                            <div class="mb-3">
                                <label for="email" class="form-label visually-hidden">Email:</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input type="email" id="email" name="email" class="form-control" placeholder="Email" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="mot_de_passe" class="form-label visually-hidden">Mot de passe:</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" id="mot_de_passe" name="mot_de_passe" class="form-control" placeholder="Mot de passe" required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-sign-in-alt"></i> Se connecter</button>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        Nouveau ici ? <a href="etudiants/inscription.php">S'inscrire ici</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
</body>

</html>
