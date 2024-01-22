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
//meme chose que connecte.php
?> 

<h3> Vous etes admin et pouvez donc changer le role de chaque utilisateur. </h3> <br> 
<h4> Attention, si vous attribuez le role d'admin à un utilisateur, vous pourrez encore changer son role et inversement, donc définissez bien les regles ! </h4> 
<br><br>

<form method="POST"> <!-- formulaire pour rechercher un user et changer ses informations --> 
    <input type="text" name="nom_user" placeholder="nom de l'utilisateur" required> 
    <input type="text" name="prenom_user" placeholder="prenom de l'utilisateur" required>
    <input type="submit" value="Rechercher">
</form>  

<?php 
if (isset($_POST["nom_user"]) && isset($_POST["prenom_user"])){
    $req_recherche = $bdd->prepare("SELECT * from user WHERE prenom_user = :prenom_u AND nom_user = :nom_u"); 
    $req_recherche->execute([
        "prenom_u" => $_POST["prenom_user"], 
        "nom_u" => $_POST["nom_user"],
    ]);
    $res_req_recherche = $req_recherche->fetchall(); 
    $userActif = $res_req_recherche[0]; 
    if (count($res_req_recherche)==0){ // si la requete n'a rien donné ca signifie que on a pas eu de user correspondant aux entrées.
        echo "utilisateur introuvable";
    }
    else {
        // print_r($userActif); //debug
        ?>
        <form method="POST"> <!-- form pour modifier eventuellement les info du user --> 
            <input type="text" name="modif_nom_user" placeholder="nouveau nom" value=<?=$userActif["nom_user"]?> required> 
            <input type="text" name="modif_prenom_user" placeholder="nouveau prenom" value=<?=$userActif["prenom_user"]?> required>
            <input type="text" name="modif_mail_user" placeholder="nouveau mail" value=<?=$userActif["mail"]?>> 
            <input type="text" name="modif_role_user" placeholder="nouveau role" value=<?=$userActif["role"]?>>    
            <input type="submit" value="Rechercher">        
        </form><?php

    if (isset($_POST["modif_nom_user"]) && isset($_POST["modif_prenom_user"]) && isset($_POST["modif_mail_user"]) && isset($_POST["modif_role_user"])){
        $req_insertion = $bdd->prepare("UPDATE user SET nom_user=:nv_n, prenom_user=:nv_p, mail=:nv_m, role=:nv_r WHERE id_user = :id_u"); 
        $req_insertion->execute([
            "nv_n"=>$_POST["modif_nom_user"], 
            "nv_p"=>$_POST["modif_prenom_user"], 
            "nv_m"=>$_POST["modif_mail_user"], 
            "nv_r"=>$_POST["modif_role_user"],      
            "id_u"=>$userActif["id_user"],  
        ]);
        echo "Mise à jour effectuée avec succès"; // mise a jour dans la bdd (fonctionne pas encore, à check)
        }
    }
}