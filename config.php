<?php

try {
    $pdo = new PDO("mysql:host=localhost;dbname=sunuplateforme", "root", "");
} catch (PDOException $e) {
    echo $e->getMessage();
}
