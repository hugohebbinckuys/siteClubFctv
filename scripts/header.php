<?php
try {
    $bdd = new PDO('mysql:host=localhost;dbname=sdn_php_projet;charset=utf8', 'root', ''); // connexion à bdd 
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // s'informer si pb
} 
catch (Exception $e){
    die("Erreur: ".$e->getMessage()); // message d'erreur clair si pb il y a eu 
}
?> 
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fctv</title> <!-- ajouter image du fctv dans le titre comme j'avais vu sur youtube --> 
    <link rel="icon" type="image/jpg" href="logoFctv.jpg"> <!-- marche pas --> 
    <link rel="stylesheet" type="text/css" href="index.css">
</head>

<?php
if (isset($_SESSION['user_name'])){
    return;
}
else {
    $_SESSION['user_name'] = "no_inscription";
}

