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

$req_joueurs_eq = $bdd->prepare("SELECT * FROM joueur WHERE id_equipe=:id_e");
$req_joueurs_eq -> execute(["id_e"=>$_SESSION['equipeActive']['id_equipe']]);
$joueurs = $req_joueurs_eq->fetchall();  //recup des joueurs 

if (isset($_POST['prenom_entraineur']) && isset($_POST['nom_entraineur']) && isset($_POST['date_naiss_entraineur']) && isset($_POST['date_arrivee_entraineur']) && isset($_POST['mail_entraineur'])){
    $req_entraineurs_eq = $bdd->prepare("SELECT * FROM entraineur WHERE id_equipe=:id_e");
    $req_entraineurs_eq -> execute(["id_e"=>$_SESSION['equipeActive']['id_equipe']]);
    $res_entraineurs = $req_entraineurs_eq->fetchall();  
    $entraineur_deja_entre = 0;
    foreach ($res_entraineurs as $entraineur){
        if ($entraineur['nom_entraineur'] == $_POST['nom_entraineur'] && $entraineur['prenom_entraineur'] == $_POST['prenom_entraineur']) {?>
            <script type="text/javascript"> alert("L'entraineur est deja rentré"); </script><?php
            $entraineur_deja_entre = 1;
        }
        else continue; 
    }//meme fonctionnement que pour les autres fichiers 
if ($entraineur_deja_entre != 1){
    $insert_entraineur = $bdd->prepare("INSERT INTO entraineur (nom_entraineur, prenom_entraineur, date_naissance, date_arrivee, mail, id_equipe) VALUES (:nom_e, :prenom_e, :date_n, :date_a, :mail_e, :id_e)"); 
    $insert_entraineur->execute([
        'nom_e' => $_POST['nom_entraineur'], 
        'prenom_e' => $_POST['prenom_entraineur'], 
        'date_n' => $_POST['date_naiss_entraineur'],
        'date_a' => $_POST['date_arrivee_entraineur'], 
        'mail_e' => $_POST['mail_entraineur'], 
        'id_e' => $_SESSION['equipeActive']['id_equipe'],
        ]); ?> 
        <script type="text/javascript"> alert("Entraineur rentré avec succès !"); window.location.href = "connecte.php"; window.location.href = "equipe.php";</script> <!-- redirection vers connecte pour actualiser les requetes et les nouvelles données -->
<?php
    }
}

// suppression entraineur : //

if (isset($_POST['prenom_entraineur_supression']) && $_POST['nom_entraineur_supression']){
    $supr_entraineur_ok = FALSE;
    foreach ($_SESSION['entraineurs'] as $entraineur){
        if ($_POST['prenom_entraineur_supression'] == $entraineur['prenom_entraineur'] && $_POST['nom_entraineur_supression'] == $entraineur['nom_entraineur']){
            $supr_entraineur_ok = TRUE; 
            break; 
        }
        else {
            continue; 
        }
    }
    if ($supr_entraineur_ok){
        $req_supr_ent = $bdd->prepare("DELETE FROM entraineur WHERE prenom_entraineur = :prenom_ent AND nom_entraineur = :nom_ent"); 
        $req_supr_ent->execute([
            "prenom_ent"=>$_POST["prenom_entraineur_supression"], 
            "nom_ent"=>$_POST["nom_entraineur_supression"]]); 
            ?> 
        <script type="text/javascript"> alert("Entraineur supprimé avec succès !"); window.location.href = "connecte.php"; window.location.href = "equipe.php";</script><?php
    }    
    if ($supr_entraineur_ok == FALSE){
        ?> <script type="text/javascript"> alert("Entraineur introuvable"); </script> <?php
    }
}

// insertion nouveau joueur : //

if (isset($_POST['prenom_joueur']) && isset($_POST['nom_joueur']) && isset($_POST['date_naiss_joueur']) && isset($_POST['date_arrivee_joueur']) && isset($_POST['mail_joueur']) && isset($_POST['poste_joueur'])){    
    $req_joueurs_eq = $bdd->prepare("SELECT * FROM joueur WHERE id_equipe=:id_e");
    $req_joueurs_eq -> execute(["id_e"=>$_SESSION['equipeActive']['id_equipe']]);
    $joueurs = $req_joueurs_eq->fetchall(); 
    $joueur_deja_rentre = FALSE; 
    foreach ($joueurs as $joueur) {
        if ($joueur['nom_joueur'] == $_POST['nom_joueur'] && $joueur["prenom_joueur"] == $_POST['prenom_joueur']) {?><script type="text/javascript"> alert("Le joueur est deja rentré dans l'équipe"); </script><?php
            $joueur_deja_rentre = TRUE;
        }
        else continue; 
    }
if (!$joueur_deja_rentre){
    $insert_joueur = $bdd->prepare("INSERT INTO joueur (nom_joueur, prenom_joueur, date_naissance_joueur, date_arrivee_joueur, mail_joueur, poste_joueur, id_equipe) VALUES (:nom_j, :prenom_j, :date_n, :date_a, :mail_j, :poste_j, :id_e)"); 
    $insert_joueur->execute([
        'nom_j' => $_POST['nom_joueur'],
        'prenom_j' => $_POST['prenom_joueur'],
        'date_n' => $_POST['date_naiss_joueur'],
        'date_a' => $_POST['date_arrivee_joueur'],
        'mail_j' => $_POST['mail_joueur'],
        'poste_j' => $_POST['poste_joueur'],
        'id_e' => $_SESSION['equipeActive']['id_equipe'],
    ]); ?>
    <script type="text/javascript"> alert("Joueur rentré avec succès !"); window.location.href = "connecte.php"; window.location.href = "equipe.php";</script> <!-- redirection vers connecte pour actualiser les requetes et les nouvelles données --> <?php
    }
}
// fin d'insertion de joueur //  
// suppression de joueur : // 

if (isset($_POST['prenom_joueur_supression']) && $_POST['nom_joueur_supression']){
    $req_joueurs_eq = $bdd->prepare("SELECT * FROM joueur WHERE id_equipe=:id_e");
    $req_joueurs_eq -> execute(["id_e"=>$_SESSION['equipeActive']['id_equipe']]);
    $joueurs = $req_joueurs_eq->fetchall(); 
    $supr_joueur_ok = FALSE;
    foreach ($joueurs as $joueur){
        if ($_POST['prenom_joueur_supression'] == $joueur['prenom_joueur'] && $_POST['nom_joueur_supression'] == $joueur['nom_joueur']){
            $supr_joueur_ok = TRUE; 
            break; 
        }
        else {
            continue; 
        }
    }
    if ($supr_joueur_ok == TRUE){
        $req_supr_ent = $bdd->prepare("DELETE FROM joueur WHERE prenom_joueur = :prenom_j AND nom_joueur = :nom_j"); 
        $req_supr_ent->execute([
            "prenom_j"=>$_POST["prenom_joueur_supression"], 
            "nom_j"=>$_POST["nom_joueur_supression"]]); 
            ?> 
        <script type="text/javascript"> alert("joueur supprimé avec succès !"); window.location.href = "connecte.php"; window.location.href = "equipe.php";</script><?php
    }    
    if ($supr_joueur_ok == FALSE){
        ?> <script type="text/javascript"> alert("Joueur introuvable");</script><?php
    }
}


?> 
<div class="retour_connecte">
    <a href="connecte.php#equipes"> Retourner à la page principale </a>
</div>
<br>

<div class="admin">
    <p> Vous êtes administrateur, vous pouvez gérer les joueurs / entraineurs de l'équipe</p>
</div>
<div class="lien_ajout_joueur">
    <a href="equipe.php#ajout_joueur"> Ajouter un joueur de l'équipe ↓ </a>
</div>
<div class="lien_ajout_entraineur">
    <a href="equipe.php#ajout_entraineur"> Ajouter un entraineur de l'équipe ↓</a>
</div>
<br>
<br> 

<div class="titre_equipe">
    <p> Voici les informations des <?=$_SESSION['equipeActive']['nom_equipe']; ?> </p> 
</div>
<br> 


<div class="entraineur_joueur">
    <table class="table">
        <tr> 
            <th><?= $_SESSION['equipeActive']['nom_equipe']?> </th> 
            <th> - </th> 
            <th><?= $_SESSION['equipeActive']['categorie']?> </th>
        </tr> 
        <tr> 
            <th> entraineur(s) </th>  
        </tr> 
        <?php
        foreach ($_SESSION['entraineurs'] as $entraineur){
            ?> 
            <tr> 
                <td> <?= $entraineur['prenom_entraineur'];?>
                <td> <?= $entraineur['nom_entraineur'];?> 
                <td> </td> 
                <td><a href="entraineur.php?id_entraineur=<?= $entraineur['id_entraineur']?>"> voir la fiche de <?=$entraineur['prenom_entraineur']." ".$entraineur['nom_entraineur']?> </a></td> 
            </tr> <?php
        }?>     
    </table>
</div><br> 

<!-- form supression entraineur --> 

<?php
if ($_SESSION['user_role'] == 'admin' && count($_SESSION['entraineurs']) != 0){?> <!-- si pas d'entraineur on affiche pas la possibilité de supprimer les entraineurs --> 
<div class="instruction_entraineur">
    <p> Supprimer un entraineur de l'équipe : </p> 
</div>
<?php
    ?> 
    <div class="form_equipe supression_Entraineur">
        <form method="POST">
            <div class="champ_ajout">
                <input type="text" id="prenom_entraineur_supression" name="prenom_entraineur_supression" placeholder="Prenom entraineur" required>
            </div>
            <div class="champ_ajout">
                <input type="text" id="nom_entraineur_supression" name="nom_entraineur_supression" placeholder="Nom entraineur" required>
            </div>
            <div class="bouton_{entraineur  supression_entraineur"> 
                <input type="submit" id="supression_entraineur" name="supression_entraineur" value="Supprimer l'entraineur"> 
            </div>
        </form>
    </div>
<?php
}
?>
<br><br>
<div class="entraineur_joueur">
    <table class="table">
        <tr> 
            <th> Effectif </th>  
            <th></th>
            <th></th>
            <th></th>
        </tr> 
        <?php 
        $requete_joueurs = $bdd->prepare("SELECT * FROM joueur WHERE id_equipe = :id_eq"); 
        $requete_joueurs -> execute(array("id_eq"=>$_SESSION['equipeActive']['id_equipe'])); 
        $joueurs = $requete_joueurs -> fetchall(); 
        foreach ($joueurs as $joueur){
            ?> 
            <tr> 
                <td> <?= $joueur['prenom_joueur'];?>
                <td> <?= $joueur['nom_joueur'];?> 
                <td> </td> 
                <td> <a href="joueur.php?id_joueur=<?=$joueur['id_joueur']?>" class="a_fiche">voir la fiche de <?=$joueur['prenom_joueur']." ".$joueur['nom_joueur']?></a></td> 
            </tr> <?php
        }?>     
    </table>
</div>
<br> 
<!-- form suppression joueur --> 

<?php
if ($_SESSION['user_role'] == 'admin' && count($joueurs) != 0){?> <!-- si pas d'entraineur on affiche pas la possibilité de supprimer les entraineurs --> 
<div class="instruction_joueur">
    <p> Supprimer un joueur de l'équipe : </p> 
</div>
<?php
    ?> 
    <div class="form_equipe supression_joueur">
        <form method="POST">
            <div class="champ_ajout">
                <input type="text" id="prenom_joueur_supression" name="prenom_joueur_supression" placeholder="Prenom joueur" required>
            </div>
            <div class="champ_ajout">
                <input type="text" id="nom_joueur_supression" name="nom_joueur_supression" placeholder="Nom joueur" required>
            </div>
            <div class="bouton_{joueur  supression_joueur"> 
                <input type="submit" id="supression_joueur" name="supression_joueur" value="Supprimer l'joueur"> 
            </div>
        </form>
    </div>
<?php
}
?>


<!-- form pour ajouter un joueur --> 
<br> <br>
<?php
if ($_SESSION['user_role'] == 'admin'){
?>
<div class="instruction instruction_entraineur" id="ajout_joueur">
    <p> Ajouter un joueur à l'équipe : </p> 
</div> 
<div class="form_equipe ajout_joueur">
    <form method="POST">
        <div class="champ_ajout">
            <input type="text" id="prenom_joueur" name="prenom_joueur" placeholder="Prenom joueur" required>
        </div>
        <div class="champ_ajout">
            <input type="text" id="nom_joueur" name="nom_joueur" placeholder="Nom joueur" required>
        </div>
        <div class="champ_ajout">
            <input type="text" id="poste_joueur" name="poste_joueur" placeholder="Poste du joueur" required>
        </div>
        <div class="champ_ajout">
            <label for="date_naiss_joueur">Date de naissance </label>
            <input type="date" id="date_naiss_joueur" name="date_naiss_joueur" required>
        </div>
        <div class="champ_ajout">
            <label for="date_arrive_joueur">Date d'arrivee </label>
            <input type="date" id="date_arrivee_joueur" name="date_arrivee_joueur" placeholder="Date d'arrivée joueur" required>
        </div>
        <div class="champ_ajout">
            <input type="mail" id="mail_joueur" name="mail_joueur" placeholder="mail joueur" required>
        </div>        
        <div class="bouton_joueur ajout_joueur"> 
            <input type="submit" id="ajout_joueur" name="ajout_joueur" value="Ajouter un joueur"> 
        </div>
    </form>
</div>
<?php
}?> 

<br> <br> 

<?php
if ($_SESSION['user_role'] == 'admin'){
?>
<div class="instruction instruction_entraineur" id="ajout_entraineur">
    <p> Ajouter un entraineur à l'équipe : </p> 
</div>
<div class="form_equipe ajout_entraineur">
    <form method="POST">
        <div class="champ_ajout">
            <input type="text" id="prenom_entraineur" name="prenom_entraineur" placeholder="*Prenom entraineur" required>
        </div>
        <div class="champ_ajout">
            <input type="text" id="nom_entraineur" name="nom_entraineur" placeholder="*Nom entraineur" required>
        </div>
        <div class="champ_ajout">
            <label for="date_naiss_entraineur">Date de naissance </label>
            <input type="date" id="date_naiss_entraineur" name="date_naiss_entraineur" required>
        </div>
        <div class="champ_ajout">
            <label for="date_arrive_entraineur">Date d'arrivee </label>
            <input type="date" id="date_arrivee_entraineur" name="date_arrivee_entraineur" required>
        </div>
        <div class="champ_ajout">
            <input type="mail" id="mail_entraineur" name="mail_entraineur" placeholder="*mail entraineur" required>
        </div>
        <div class="champ_ajout">
            
        </div>
        <div class="bouton_entraineur ajout_entraineur"> 
            <input type="submit" id="ajout_entraineur" name="ajout_entraineur" value="Ajouter un entraineur"> 
        </div>
    </form>
</div>
<br><br>
<?php
}


?>
<?php require("footer.php");?>