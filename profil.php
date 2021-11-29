<?php

$BDDSQL = array();
$BDDSQL['host'] = "localhost";
$BDDSQL['user'] = "root";
$BDDSQL['pass'] = "";
$BDDSQL['db'] = "moduleconnexion";

session_start();

if (!isset($_SESSION['login'])){

    header("Refresh: 3; url=connexion.php");
    echo "Vous devez être connecté pour accéder à cette page. <br> Redirection vers la page de connexion en cours...";
    exit(0);

}

$mysqli=mysqli_connect($BDDSQL['host'],$BDDSQL['user'],$BDDSQL['pass'],$BDDSQL['db']);

if (!$mysqli){

    echo "Connexion à la base de données non établie.";
    exit;

}

$AfficherFormulaire = 1;
$FormulaireMDP = 0;
$req = mysqli_query($mysqli,"SELECT * FROM utilisateurs WHERE login='".$_SESSION['login']."'");
$info = mysqli_fetch_array($req); 

if (isset($_POST['deconnexion'])) {

    session_destroy();

    header('Refresh: 0; url=index.php');

}

if(isset($_POST['goformmdp'])) {

    $FormulaireMDP = 1 ; 
    $AfficherFormulaire = 0; 
}

if (isset($_POST['modifmdp'])){

    $password = $_POST['password'] ;
    $newpass = $_POST['newpass'];
    $confirmpass = $_POST['confirmpass'];
    $testmdp = mysqli_query($mysqli, "SELECT * FROM utilisateurs WHERE password = '".$password."'");

    if (empty($password)){

        $erreurpass = "Le champ mot de passe actuel est vide.";

    }

    elseif (mysqli_num_rows($testmdp)==0){

        $erreurpass = "Le mot de passe actuel est incorrect.";

    }

    elseif (empty($newpass)){

        $erreurpass = "Le champ nouveau mot de passe est vide.";

    }

    elseif (empty($confirmpass)){

        $erreurpass = "Le champ de confirmation du mot de passe est vide.";

    }

    elseif ($newpass != $confirmpass){

        $erreurpass = "Le nouveau mot de passe et sa confirmation ne correspondent pas.";
    
    }

    else {

        if (mysqli_query($mysqli, "UPDATE utilisateurs SET password = '".$newpass."' WHERE login='".$_SESSION['login']."'")){

            $confirmpass = "Votre mot de passe a été changé avec succès.";
            $FormulaireMDP = 0;
            $AfficherFormulaire = 1;

        }
    }
}

if(isset($_POST['modifier'])) {

    $Login = $_POST['login'];
    $Prenom = $_POST['prenom'];
    $Nom = $_POST['nom'];
    

    $testlogin = mysqli_query($mysqli, "SELECT * FROM utilisateurs WHERE login='".$Login."'");
    $mysqli_resultlogin = mysqli_num_rows($testlogin) ;
    $requetemdp = mysqli_query($mysqli, "SELECT * FROM utilisateurs WHERE password= '".$_POST['password']."'");

    if (empty($Login)){

        $erreurlogin = "Le champ Login est vide.";

    }

    elseif ($Login != ($_SESSION['login'])){

        if (($mysqli_resultlogin)==1){

            $erreurlogin = "Ce login est déjà utilisé.";

        }
    }

    if (empty($Prenom)){

        $erreurprenom = "Le champ Prenom est vide.";

    }

    if (empty($Nom)){

        $erreurnom = "Le champ Nom est vide.";

    }

    if (empty($_POST['password'])){

        $erreurpass = "Le mot de passe doit être renseigné.";

    }

    elseif (mysqli_num_rows($requetemdp)==0){

        $erreurpass = "Le mot de passe est incorrect.";
      
    }
    
    else {

    $updateinfos = "UPDATE utilisateurs SET login ='".$Login."', prenom ='".$Prenom."', nom ='".$Nom."' WHERE login = '".$_SESSION['login']."'";
        
        if (mysqli_query($mysqli, $updateinfos)){
            
            $_SESSION['login'] = $Login;
            $req = mysqli_query($mysqli,"SELECT * FROM utilisateurs WHERE login='".$_SESSION['login']."'");
            $info = mysqli_fetch_array($req); 
            $AfficherFormulaire = 0;
            $confirmmodifs = "Modifications effectuées avec succès !";

        }

    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil membre</title>
    <link rel="stylesheet" href="css/autrespages.css">

</head>
<body>
    
<header> 

    <h1 id="titre_header2" data-text="Module de connexion"> Module de connexion </h1>
    <div id="titre_header"><h4> Valentin MATHIEU </h4></div>
    <div>

</header>

<main>

    <h1 id="titre_profil"><u> Modifier votre profil </u></h1>
    <br><br>

    <section class="messages">
        <?php if (isset($confirmmodifs)) {echo $confirmmodifs;} ?>
        <?php if (isset($confirmpass)) {echo $confirmpass;} ?>
    </section>

    <div class="erreurs">
        <?php if(isset($erreurlogin)) {echo $erreurlogin ;}
              if(isset($erreurprenom)) {echo $erreurprenom ;}
              if(isset($erreurnom)) {echo $erreurnom ;}
              ?> <br> <?php
              if(isset($erreurpass)) {echo $erreurpass ;}
        ?>
    </div>

    <?php if ($AfficherFormulaire==1){ ?>

        <form class="form" action="profil.php" method="post">
            <br>
            <label for="login"> Nouveau login : </label>
            <input type="text" name="login" value="<?php echo $info['login']; ?>">
            <br>
            <label for="prenom"> Nouveau prénom : </label>
            <input type="text" name="prenom" value="<?php echo $info['prenom']; ?>">
            <br>
            <label for="nom"> Nouveau nom : </label>
            <input type="text" name="nom" value="<?php echo $info['nom']; ?>">
            <br>
            <label for="password"> Mot de passe : </label>
            <input type="password" name="password" placeholder="Entrez votre mot de passe">
            <br><br>
            <div class="bouton_profil_form">
            <button class="bouton_form" type="submit" name="modifier"> Confirmer les informations </button>
            </div>
        </form>

    <?php } 

    if ($FormulaireMDP==1){ ?>
        <form class="form" action="profil.php" method="post">
            <br>
            <label for="password"> Mot de passe actuel : </label>
            <input type="password" name="password" placeholder="Entrez votre mot de passe actuel">
            <br>
            <label for="newpass"> Nouveau mot de passe : </label>
            <input type="password" name="newpass" placeholder="Entrez votre nouveau mot de passe">
            <br>
            <label for="confirmpass"> Confirmation du mot de passe : </label>
            <input type="password" name="confirmpass" placeholder="Confirmez votre nouveau mot de passe">
            <br><br>
            <div class="bouton_mdp_form">
            <button class="bouton_form" type="submit" name="modifmdp"> Confirmer votre nouveau mot de passe </button>
            </div>
        </form>
    <?php } ?>

    <?php if ($FormulaireMDP == 0){ ?>
        <form action="profil.php" method="post">
            <input class="bouton_profil" type="submit" name="goformmdp" value="Changer votre mot de passe">
        </form>
    <?php } ?>

    <form action="profil.php" method='post'>
        <input class="bouton_profil" type="submit" name="deconnexion" value="Se déconnecter"> 
    </form>

</main>

<footer>    

    <h3 id="titre_footer"> Attention ! Si vous cliquez sur les images ci-dessous : <br> À gauche, vous risqueriez de tomber sur mon Github... <br> À droite, sur mon Linkedin... </h3>
    <br>
    <div class="logos_footer">
    <a href="https://github.com/valentin-mathieu" target="blank"><img height="110px" width="110px" src="Assets/logo_github.png" alt="github"></a>
    <a href="https://linkedin.com/in/valentin-mathieu-6857ab21b" target="blank"><img height="130px" width="130px" src="Assets/logo_linkedin.png" alt="linkedin"></a>
    </div>

</footer>
</body>
</html>