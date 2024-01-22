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
// ici on vérifie i l'utilisateur s'est connecté

?>
<body>
<!-- header - navbar --> 
    <header class="header">
        <!-- <a href="#" class="petit_logo_navbar"> <img src="../images/logo_fctv_b&w.png" alt="logo fctv noir et blanc" class="logo_bw"></a> -->
        <div class="navbar_container">
            <!-- <nav class="navbar navbar_connecte">  -->
                <div>
                    <a href="#"> Accueil </a>
                </div>
                <div>
                    <a href="#equipes"> les équipes </a>
                </div>
                <div>
                    <a href="#actualites"> l'actualité </a>
                </div>
                <div>
                    <a href=""><img src="../images/logo_fctv.png" alt="logo fctv" class="logoFctv"></a>
                </div>
                <div>
                    <a href="#infrastructure"> les infrastructures </a>
                </div>
                <div>
                    <a href="#a_propos"> à propos </a> 
                </div>
                <div>
                    <a href="accueil_connexion.php" class="droite"> se connecter </a>
                </div>
            <!-- </nav> -->
        </div>
    </header> 
<br><br><br><br><br>
<!-- main content --> 
    <div class="main"> 
        <div class="connect_sous">
            <p> connecté sous le nom de <?=$_SESSION['user_firstName'].' '.$_SESSION['user_name']; 
            ?> </p> 
            <p> <?= 'debug role du user actuel : '.$_SESSION['user_role']; ?> 
        </div>
        <?php
        if ($_SESSION['user_role'] == 'admin'){
            ?> 
            <div class="admin">
                <a href="admin.php"> Voir les paramètres administrateurs des comptes </a> 
            </div> 
            <?php // on peut voir les parametres admin que si on est admin donc on verifie. 
        }
        ?> 
        <div class="img_fond"> 
            <img src="../images/photo_equipe.jpg" alt="image de l'équipe">
        </div>
        <div class="section">
            <div class="titre_section">
                <h2 id="equipes"> Les équipes </h2> 
            </div>
            <div class="section_container"> 
                <div class="equipe_select_container">
                    <div class="button_container">
                        <form method="POST" enctype="multipart/form-data" action="connecte.php#equipes"> 
                            <select name="equipes" id="equipe_select">
                                <option value="0">Sélectionnez une équipe</option>
                                <?php
                                $requete_equipes = $bdd->query("SELECT * from equipe GROUP BY id_equipe");
                                $equipes = $requete_equipes->fetchall();
                                $_SESSION['equipes'] = $equipes; 
                                foreach ($equipes as $equipe) {
                                    ?><option value="<?= $equipe['id_equipe']?>"> <?= $equipe['nom_equipe'] ?> </option><?php
                                } // pour selectionner l'équipe qu'on veut afficher 
                                ?>
                            </select>
                            <input type="submit" value="Afficher l'équipe">  
                        </form> 
                    </div>  
                </div>    
                <div class="equipe_container"> 
                    <table class="table_equipe"> 
                        <tr>
                            <th> EQUIPE </th> 
                            <th> NIVEAU </th> 
                            <th> ENTRAINEUR(S) </th>
                            <th> EN SAVOIR PLUS </th>
                        </tr>

                    <?php
                    if (isset($_POST['equipes'])){ // si l'equipe a ete selectionne alors on affiche celle selectionnée
                        $id_equipeActive = $_POST['equipes']; //definition de l'equipe active u'on veut voir.
                        if ($id_equipeActive==0){ // si le select selectionné est "Sélectionnez une equipe" alors l'id de l'equipe est mis à 0; => donc on affiche les seniors
                            $requete_seniors = $bdd->query("SELECT * FROM equipe WHERE nom_equipe = 'Seniors A'");
                            $res_req_seniors = $requete_seniors->fetchall(); // recup des données
                            $seniors = $res_req_seniors[0]; // le premier array est l'équipe (ici les séniors)
                            $_SESSION['equipeActive'] = $seniors; //définition en variable de session 
                            ?><tr> 
                                <th><?= $seniors['nom_equipe']?> 
                                <td><?= $seniors['categorie']?> <?php
                            $requete_entraineurs = $bdd->query("SELECT * from entraineur WHERE entraineur.id_equipe = 1");
                            $entraineurs = $requete_entraineurs->fetchall();
                            $_SESSION['entraineurs'] = $entraineurs; // meme chose pour l'entraineur
                            $condition_arret = 0; 
                            // print_r($entraineurs);
                            if (count($entraineurs) == 0){?> <!-- si il n'y a pas d'entraineurs il faut afficher qqch quand meme --> 
                                <td></td>
                                <td><a href="equipe.php?id_equipe=1"> Details sur les <?=$seniors['nom_equipe']?></a></td><?php
                            }
                            else { // sinon on affiche chaque entraineur 
                                foreach ($entraineurs as $entraineur){
                                    if ($condition_arret == 0){ 
                                    ?>
                                        <td><a href="entraineur.php?id_entraineur=<?=$entraineur['id_entraineur']?>"><?=$entraineur['prenom_entraineur']." ".$entraineur['nom_entraineur']?></a></td>
                                        <td><a href="equipe.php?id_equipe=1"> Details sur les <?=$seniors['nom_equipe']?></a></td>  
                                    </tr> <?php
                                    $condition_arret = 1; // pour le premier entraineur car on doit mettre le detail d'equipe uniquement à la premiere ligne et pas aux suivantes
                                    }
                                    else {?>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td><a href="entraineur.php?id_entraineur=<?=$entraineur['id_entraineur']?>"><?=$entraineur['prenom_entraineur']." ".$entraineur['nom_entraineur']?></a></td>
                                        <td><a href="equipe.php?id_equipe=1"> Details sur les <?=$seniors['nom_equipe']?></a></td>
                                    </tr>
                                    <?php
                                    }
                                }
                            }
                        }
                        else { // sinon si l'id est pas à 0 alors on va chercher l'id de la bonne equipe via le form;
                            $requete_equipe_active = $bdd->prepare("SELECT * FROM equipe WHERE id_equipe = :id_equipeActive");
                            $requete_equipe_active -> execute(array("id_equipeActive" => $id_equipeActive)); 
                            $res_equipeActive = $requete_equipe_active->fetchall(); 
                            $equipeActive = $res_equipeActive[0]; 
                            $_SESSION['equipeActive'] = $equipeActive; 
                            // print_r($equipeActive); 
                            ?><tr> 
                            <th class="nom_rouge"><?=$equipeActive['nom_equipe']?> 
                            <td><?=$equipeActive['categorie']?> <?php
                            $requete_entraineurs = $bdd->prepare("SELECT * from entraineur WHERE entraineur.id_equipe = :id_eq");
                            $requete_entraineurs -> execute(array('id_eq'=>$equipeActive['id_equipe']));
                            $entraineurs = $requete_entraineurs->fetchall();
                            $_SESSION['entraineurs'] = $entraineurs;
                            // print_r($joueurs);
                            $condition_arret = 0; 
                            if (count($entraineurs)==0){ // si y a pas d'entraineur o naffiche 
                                // echo "yo y a pas dentraineur"; ?>
                                    <td></td> 
                                    <td><a href="equipe.php?id_equipe=<?=$equipeActive['id_equipe']?>"> Details sur les <?=$equipeActive['nom_equipe']?></a></td> 
                                <?php
                            }
                            else {
                                // echo "yo y a un entraineur"; 
                                foreach($entraineurs as $entraineur){
                                    if ($condition_arret==0){?> <!-- condition d'arret = 0 si on est au premier entraineur (ce qui fait que on doit initier les titres de colonnes) on doit pas le faire une duexieme fois lors de l'affichage du deuxieme entraineur; -->
                                        <td><a href="entraineur.php?id_entraineur=<?=$entraineur['id_entraineur']?>"><?=$entraineur['prenom_entraineur']." ".$entraineur['nom_entraineur']?> </a></td> 
                                        <td><a href="equipe.php?id_equipe=<?=$equipeActive['id_equipe']?>"> Details sur les <?=$equipeActive['nom_equipe']?></a></td> 
                                        </tr> <?php
                                        $condition_arret = 1; 
                                    }
                                    else {?>
                                        <tr>
                                            <td></td>
                                            <td></td> 
                                        <td><a href="entraineur.php?id_entraineur=<?=$entraineur['id_entraineur']?>"><?=$entraineur['prenom_entraineur']." ".$entraineur['nom_entraineur']?> </a></td>
                                        </tr><?php
                                    }
                                }
                            }
                        }   
                    }
                    else { // sinon si est pas rempli on affiche les séniors (id_equipe =1) 
                        $requete_seniors = $bdd->query("SELECT * FROM equipe WHERE nom_equipe = 'Seniors A'");
                        $res_req_seniors = $requete_seniors->fetchall();
                        $seniors = $res_req_seniors[0]; 
                        $_SESSION['equipeActive'] = $seniors; 
                        $equipeActive = $_SESSION['equipeActive']; 
                      ?><tr> 
                            <th><?= $seniors['nom_equipe']?> 
                            <td><?= $seniors['categorie']?> <?php
                        $requete_entraineurs = $bdd->query("SELECT * from entraineur WHERE entraineur.id_equipe = 1");
                        $entraineurs = $requete_entraineurs->fetchall();
                        $_SESSION['entraineurs'] = $entraineurs; 
                        // print_r($entraineurs);
                        $condition_arret = 0; 
                        if (count($entraineurs)==0){ // si y a pas d'entraineur o naffiche 
                            // echo "yo y a pas dentraineur"; ?>
                                <td></td> 
                                <td><a href="equipe.php?id_equipe=<?=$equipeActive['id_equipe']?>"> Details sur les <?=$equipeActive['nom_equipe']?></a></td> 
                            <?php
                        }
                        else {
                            foreach ($entraineurs as $entraineur){
                                if ($condition_arret == 0){
                                ?>
                                    <td><a href="entraineur.php?id_entraineur=<?= $entraineur['id_entraineur']?>"><?=$entraineur['prenom_entraineur']." ".$entraineur['nom_entraineur']?> </a></td> 
                                    <td><a href="equipe.php?id_equipe=1"> Details sur les <?=$seniors['nom_equipe']?></a></td>  
                                </tr> <?php
                                $condition_arret = 1;
                                }
                                else {?> 
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td><a href="entraineur.php?id_entraineur=<?=$entraineur['id_entraineur']?>"><?=$entraineur['prenom_entraineur']." ".$entraineur['nom_entraineur']?> </a></td>
                                </tr><?php
                                }
                            }
                        }
                    }
                    ?>
                    </table> 
                </div> 
            </div> 
        </div> 

<br><br><br>

        <div class="section">
            <div class="titre_section">
                <h2 id="actualites"> Suivez les actus' du Fctv ! </h2> 
            </div>
            <div class="section_container">
                <div class="actu_container" id="premiere_actu">
                    <div class="titre_actu">    
                        <h3> Titre actu 1 </h3> 
                    </div>    
                    <div class="actu_image_container">
                        <img src="" alt="image actu">
                    </div> 
                    <div class="actu_text_container">
                        <p> voici l actu </p> 
                        <p> voici l actu </p> 
                        <p> voici l actu </p> 
                        <p> voici l actu </p> 
                    </div>
                </div>
                <div class="actu_container" id="deuxieme_actu">
                    <div class="titre_actu"> 
                        <h3> Titre actu 2 </h3> 
                    </div>   
                    <div class="actu_image_container">
                        <img src="" alt="image actu">
                    </div> 
                    <div class="actu_text_container">
                        <p> voici l actu </p> 
                        <p> voici l actu </p> 
                        <p> voici l actu </p> 
                        <p> voici l actu </p> 
                    </div>
                </div>
            </div>
        </div>

<br><br><br>

        <div class="section">
            <div class="titre_section">
                <h2 id="infrastructures"> Les infrastructures </h2> 
            </div>
            <div class="section_container">
                <div class="infrastructure_container">
                    <div class="titre_infrastructure">
                        <h3> infrastructure 1 </h3>
                    </div>
                    <div class="image_infrastructure">
                        <img src="" alt="">
                    </div>
                    <div class="description_infrastructure">
                        <p> le stade a été construit en </p> 
                    </div>
                </div>
            </div> 
            <div class="section_container">
                <div class="infrastructure_container">
                    <div class="titre_infrastructure">
                        <h3> infrastructure 2 </h3>
                    </div>
                    <div class="image_infrastructure">
                        <img src="" alt="">
                    </div>
                    <div class="description_infrastructure">
                        <p> le club house a été construit en </p> 
                    </div>
                </div>
            </div>
        </div>

<br><br><br>

        <div class="section">
            <div class="titre_section">
                <h2 id="a_propos"> A propos </h2> 
            </div>
            <div class="section_container">
                <div class="bureau">
                    <div class="bureau_item">
                        <div class="bureau_item_titre">
                            <h4> Président </h4> 
                        </div>
                        <div class="bureau_item_photo">
                            <img src="" alt="">
                        </div>
                        <div class="bureau_item_nom">
                            <h5><?php 
                            
                            $requete_president = $bdd->query("SELECT * FROM benevole WHERE role_benevole = 'president'"); 
                            $res_req_president = $requete_president->fetchall(); 
                            $president = $res_req_president[0]; 
                            // print_r ($president); 
                                echo ($president['prenom_benevole']." ".$president["nom_benevole"]);
                                // echo ($president[0]." ".$president());
                            ?></h5> 
                        </div>
                    </div>

                    <div class="bureau_item">
                        <div class="bureau_item_titre">
                            <h4> Secretaire </h4> 
                        </div>
                        <div class="bureau_item_photo">
                            <img src="" alt="">
                        </div>
                        <div class="bureau_item_nom">
                            <h5><?php 
                            
                            $requete_secretaire = $bdd->query("SELECT * FROM benevole WHERE role_benevole = 'secretaire'"); 
                            $res_req_secretaire = $requete_secretaire->fetchall(); 
                            $secretaire = $res_req_secretaire[0]; 
                            // print_r ($president); 
                                echo ($secretaire['prenom_benevole']." ".$secretaire["nom_benevole"]);
                                // echo ($president[0]." ".$president());
                            ?></h5> 
                        </div>
                    </div>

                    <div class="bureau_item">
                        <div class="bureau_item_titre">
                            <h4> Tresorier </h4> 
                        </div>
                        <div class="bureau_item_photo">
                            <img src="" alt="">
                        </div>
                        <div class="bureau_item_nom">
                            <h5><?php 
                            
                            $requete_tresorier = $bdd->query("SELECT * FROM benevole WHERE role_benevole = 'tresorier'"); 
                            $res_req_tresorier = $requete_tresorier->fetchall(); 
                            $tresorier = $res_req_tresorier[0]; 
                            // print_r ($president); 
                                echo ($tresorier['prenom_benevole']." ".$tresorier["nom_benevole"]);
                                // echo ($president[0]." ".$president());
                            ?></h5> 
                        </div>
                    </div>
                </div> 
            </div> 
        </div> 

<br><br><br>

    </div>
        <?php 
        // if ($_SESSION['user_role'] == 'admin'){
        //     // echo ("<br> Ok il est admin"); 
            
        // }
        // <!-- la on a le role en variable de session donc on pourra mouler les infos en fonction du role mais faire taches principales avant 
    ?> 

    <?php require ("footer.php"); ?>