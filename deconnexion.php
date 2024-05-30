<?php
session_start();
session_destroy(); // Destruction de la session
header("Location: index.php"); // Redirection vers la page de connexion après la déconnexion
exit;
?>
