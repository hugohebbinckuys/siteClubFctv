<?php
session_start();
$_SESSION['user_name'] = "no_user_connected"; // def variable de session pour qu'on puisse pas pouvoir accéder aux pages qui necéssitent d'etre connecté. 

require("header.php"); // importation du hader semblable à toutes les pages de notre site
$requete = $bdd->query("SELECT nom_user, prenom_user, mail, password, role from user");//savoir l'user 
if ($requete) {
    $liste_user = $requete->fetchall();
}
else {
    echo "problème dans la récupération des données dans la table 'user'";
}
$tableau_user = [];
foreach($liste_user as $user) {
    $tab = [];
    // echo $user['nom_user']." ".$user['prenom_user']." ".$user['mail']."<br>";
    array_push($tab, $user['nom_user'], $user['prenom_user'], $user['mail'], $user['password'], $user['role']);
    array_push($tableau_user, $tab);
}//on ajouter chaque user au tableau de users 
if (isset($_POST['mail']) && isset($_POST['password'])){
    foreach ($tableau_user as $user) {
        if ($user[2] == $_POST['mail'] && $user[3] == $_POST['password']){
            echo $user[2]." ".$_POST['mail']." - ".$user[3]." ".$_POST['password']; // debug
            // $_SESSION['user_mail'] = $_POST['mail']; 
            $_SESSION['user_firstName'] = $user[0];
            $_SESSION['user_name'] = $user[1];
            $_SESSION['user_role'] = $user[4]; // deifnition de variable de session pour avoir tt le temps acces au role du user
            header("Location: connecte.php"); // si c'est bon on est redirigé vers la page connecte.php
        }
        else {
            continue;// sinon on coninue pour voir si ca coincide avec un user
        } //sinon si ca a corsspondu avec aucun user : 
    }?> <script type="text/javascript"> alert("email ou mot de passe incorrect"); </script><?php
}?> 
<body>
<!-- header - navbar --> 
    <header class="header">
        <!-- <a href="#" class="petit_logo_navbar"> <img src="../images/logo_fctv_b&w.png" alt="logo fctv noir et blanc" class="logo_bw"></a> -->
        <div class="navbar_container">    
            <!-- <nav class="navbar navbar_deconnecte">  -->
                <div>
                    <a href="#" class="petit_logo_navbar"> Accueil </a>    
                </div>
                <div>
                    <a href=""> </a>    
                </div>
                <div>
                    <a href=""> </a>    
                </div>  
                <div>
                    <a href=""><img src="../images/logo_fctv_bw.png" alt="logo fctv" class="logoFctv"></a>
                </div>
                <div>
                    <a href=""> </a>  
                </div> 
                <div>
                    <a href="#contact" class="droite"> connexion </a>
                </div>
                <div>
                    <a href="inscription.php" class="droite"> inscription </a>
                </div>
            <!-- </nav>  -->
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
        <!-- form de lien vers "s'inscrire" --> 
            <div class="form_connexion droite"> 
                <form action="inscription.php">
                    <div class="titre_form"> 
                        <p> Pas encore  de compte ? </p> 
                    </div> 
                    <div class="submit"> 
                        <input type="submit" value="s'inscrire">
                    </div> 
                </form> 
            </div>
    <!-- form de connexion  --> 
            <div class="form_connexion centre" id="connexion"> 
                <form method="POST" enctype="multipart/form-data"> 
                    <div class="titre_form" id="connxion"> 
                        <h4> Connectez-vous ! </h4> 
                    </div>
                    <div class="sousTitre_form">
                        <p> avec votre compte Fctv </p> 
                    </div>
                    <div class="champ_form">
                        <input type="text" name="mail" class="champ_input" placeholder="mail" required>
                    </div>
                    <div class="champ_form"> 
                        <input type="password" name="password" class="champ_input" placeholder="mot de passe" required>
                    </div>
                    <div class="submit"> 
                        <input type="submit" value="se connecter">
                    </div>
                </form> 
            </div> 
<!-- form vide --> 
            <div class="form_connexion vide"> 
                <form></form> 
            </div>
        </div>
        
<?php require("footer.php");?>
