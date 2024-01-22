<?php 
session_start();
if (!isset($_SESSION['user_name'])){
    header("Location: accueil_connexion.php");
}
if ($_SESSION['user_name']=="no_user_connected"){
    header("Location: accueil_connexion.php");
}
else if ($_SESSION['user_name']=="no_inscription") {
    header("Location: inscription.php"); 
}
require("header.php");//meme chose que connecte.php
?>

<div class="retour_connecte">
    <a href="equipe.php"> Retourner à l'équipe </a>
</div>
<br> <br>

<?php $joueur_id = $_GET['id_joueur']; 
$req_joueur = $bdd->prepare("SELECT * FROM joueur WHERE id_joueur = :id_joueur");
$req_joueur->execute(["id_joueur" => $_GET['id_joueur']]);
$res_req_joueur = $req_joueur -> fetchall(); 
$joueurActif = $res_req_joueur[0]; 
?>

<div class="main">
    <div class="haut_page">
        <div class="image_container">
            <img src="../images/<?=$joueurActif['photo_joueur']?>" alt="photo joueur">
        </div>
        <div class="presentation_breve">
            <div class="nom_prenom">
                <p> (l'image faut la mettre a gauche et le nom prenom etc a droite de l'image)</p> 
                <p> <?= $joueurActif['prenom_joueur']." ".$joueurActif['nom_joueur'] ?> </p> 
            </div>
            <div class="naissance">
                <p> date de naissance, poste etc</p> 
            </div>
            <!-- etc etc  -->
        </div>
    </div>
</div>

<?php
require("footer.php"); 