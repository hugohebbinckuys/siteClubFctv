<?php 
session_start();
$_SESSION['user_name'] = "no_inscription"; 

require("header.php");
    // <!-- insertion dans des nouveaux comptes dans la bdd -->
// requete pour liste des user //
$requete = $bdd->query("SELECT nom_user, prenom_user, mail, role from user");
if ($requete) {
    $liste_user = $requete->fetchall();
}
else {
    echo "problème dans la récupération des données dans la table 'user'";
}

// liste des user [nom, prenom, mail] pour tester si user existe deja ou pas //
$tableau_user = [];
foreach($liste_user as $user) {
    $tab = [];
    // echo $user['nom_user']." ".$user['prenom_user']." ".$user['mail']."<br>";
    array_push($tab, $user['nom_user'], $user['prenom_user'], $user['mail'], $user["role"]);
    array_push($tableau_user, $tab);
}

// verif si utilisateur deja existant et si mail deja utilise // 
if (isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['mail']) && isset($_POST['password'])){
    foreach($tableau_user as $user){
        if ($user[0]==$_POST['nom'] && $user[1]==$_POST['prenom']){?>
            <script type="text/javascript"> alert("L'utilisateur est deja inscrit"); </script><?php
            return; 
        }
        else if ($user[2]==$_POST['mail']){?>
            <script type="text/javascript"> alert("L'e-mail est deja utilisé"); </script><?php
            // header("Location: inscription.php");
            return; 
        }
        else {
            continue;
        }
    }
    // session_destroy();    
    // session_start(); 
    $requete = $bdd->prepare("INSERT INTO `user`(nom_user, prenom_user, mail, password, role) VALUES(:nomRempli, :prenomRempli, :mailRempli, :passwordRempli, :role)");
    $requete->execute(array("nomRempli"=>$_POST['nom'], "prenomRempli"=>$_POST['prenom'], "mailRempli"=>$_POST['mail'], "passwordRempli"=>$_POST['password'], "role"=>"supporter"));
    $_SESSION['user_firstName'] = $_POST['prenom'];
    $_SESSION['user_name'] = $_POST['nom'];
    $_SESSION['user_role'] = 'supporter'; // def du role // $user[3] c le role (dans accueil_connexion c $user[4]) 
    header("Location: connecte.php");
}?>
<body>
<!-- header - navbar --> 
    <header class="header">  
        <div class="navbar_container"> 
            <div>
                <a href="#"> Accueil </a>    
            </div>
            <div>
                <a href=""></a>    
            </div>
            <div>
                <a href=""></a>    
            </div>  
            <div>
                <a href=""></a>    
            </div>  
            <div>
                <a href=""> <img src="../images/logo_fctv_bw.png" alt="logo fctv" class="logoFctv"> </a>
            </div>
            <div>
                <a href=""></a>  
            </div> 
            <!-- <a href=""></a> -->
            <!-- <a href=""> <img src="../images/logo_fctv.png" alt="logo fctv" class="logoFctv"> </a> -->
            <!-- <a href=""></a>
            <a href=""></a> -->
            <div>
                <a href="#contact" class="droite"> connexion </a>
            </div>
            <div>
                <a href="inscription.php" class="droite"> inscription </a>
            </div>
        </div>
    </header> 
<!-- main content --> 
    <div class="main"> 
        <div class="img_fond"> 
            <img src="../images/photo_equipe.jpg" alt="image de l'équipe">
        </div>

    <!-- Bienvenu et retoruvez l'actu --> 
        <div class="bienvenu">
            <h3> Bienvenu au Football Club Templemars Vendeville </h3>   
        </div> 
        <div class="intro"> 
            <h3> Retrouvez toute l'actualité du Fctv </h3> <br> 
        </div> 

        <div class="forms_container">
            <div class="form_connexion droite"> 
                <form action="accueil_connexion.php">
                    <div class="titre_form"> 
                        <p> Vous avez un compte ? </p>
                    </div> 
                    <div class="submit"> 
                        <input type="submit" value="se connecter">
                    </div> 
                </form> 
            </div>

    <!-- form d'inscription  --> 
            <div class="form_connexion centre"> 
                <form method="POST" enctype="multipart/form-data"> 
                    <div class="titre_form" id="inscription"> 
                        <h4> Inscrivez-vous ! </h4> 
                    </div>
                    <div class="sousTitre_form">
                        <p> et retrouvez toute l'actualité du Fctv ! </p> 
                    </div> 
                    <div class="champ_form"> 
                        <input type="text" name="nom" placeholder="nom" required> 
                    </div>
                    <div class="champ_form">
                        <input type="text" name="prenom" placeholder="prenom" required>       
                    </div>
                    <div class="champ_form">
                        <input type="text" name="mail" placeholder="mail" required>
                    </div>
                    <div class="champ_form">
                        <input type="password" name="password" placeholder="mot de passe" required>
                    </div>
                    <div class="submit"> 
                        <input type="submit" value="s'inscrire">
                    </div>
                </form> 
            </div> 

<!-- form vide --> 
            <div class="form_connexion vide"> 
                <form method="POST" enctype="multipart/form-data"></form> 
            </div>
        </div>
    </div>
<!-- footer --><?php
require("footer.php");
