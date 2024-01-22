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
require("header.php");
// meme chose que connecte.php 

$entraineur_id = $_GET['id_entraineur']; //recup de l'entraineur via la méthode get préparée auparavant 
$req_entraineur = $bdd->prepare("SELECT * FROM entraineur WHERE id_entraineur = :id_ent");
$req_entraineur->execute(["id_ent" => $_GET['id_entraineur']]);
$res_req_entraineur = $req_entraineur -> fetchall(); 
$entraineurActif = $res_req_entraineur[0]; // recup des infos de l'entraineur 
?>
<div class="retour_connecte">
    <a href="connecte.php#equipes"> Retourner à la page principale </a>
</div>
<div class="retour_connecte">
    <a href="equipe.php"> Retourner à l'équipe </a>
</div>
<br> <br>

<div class="main">
    <div class="haut_page">
        <div class="image_container">
            <img src="../images/<?=$entraineurActif['photo_entraineur']?>" alt=""> <!-- mettre vrai photo (pas celle la qui est juste dans le dossier --> 
        </div>
        <div class="presentation_breve">
            <div class="nom_prenom">
                <p> (l'image faut la mettre a gauche et le nom prenom etc a droite de l'image)</p> 
                <p> <?= $entraineurActif['prenom_entraineur']." ".$entraineurActif['nom_entraineur'] ?> </p> 
            </div>
            <div class="naissance">
                <p> 27/07/1995 </p> 
            </div>
            <!-- etc etc  -->
        </div>
    </div>
</div>

<?php
require("footer.php"); 