<?php 

$BDDSQL = array();
$BDDSQL['host'] = "localhost";
$BDDSQL['user'] = "root";
$BDDSQL['pass'] = "";
$BDDSQL['db'] = "moduleconnexion";

$mysqli=mysqli_connect($BDDSQL['host'],$BDDSQL['user'],$BDDSQL['pass'],$BDDSQL['db']);

if (!$mysqli){
    $erreur = "Connexion à la base de données non établie.";
    exit;
}

$AfficherFormulaire=1;

if (isset($_POST['login'],$_POST['prenom'],$_POST['nom'],$_POST['password'],$_POST['password_confirm'])){

    if (empty($_POST['login'])){

        $erreurlogin = "Le champ Login est vide.";
        
    }

    elseif (empty($_POST['prenom'])){

        $erreurprenom = "Le champ Prénom est vide.";

    }

    elseif (empty($_POST['nom'])){

        $erreurnom = "Le champ Nom est vide.";

    }

    elseif (empty($_POST['password'])){

        $erreurpass = "Le champ Mot de passe est vide.";

    }

    elseif (empty($_POST['password_confirm'])){

        $erreurpassconf = "Le champ Confirmer votre mot de passe est vide.";

    }

    elseif ($_POST['password']!==$_POST['password_confirm']){

        $erreurpass = "Les mots de passe saisis ne correspondent pas.";

    }

    elseif (mysqli_num_rows(mysqli_query($mysqli,"SELECT * FROM utilisateurs WHERE login='".$_POST['login']."'"))==1){

        $erreurlogin = "Ce login est déjà pris.";

    }

    else {

        if (!mysqli_query($mysqli, "INSERT INTO utilisateurs SET login='".$_POST['login']."' , prenom='".$_POST['prenom']."' , nom='".$_POST['nom']."' , password='".$_POST['password']."'")){

            $erreur = "Une erreur s'est produite.";

        }

        else {

            $validinscrip = "Vous êtes inscrit avec succès, redirection vers la plage de connexion en cours !";
            $AfficherFormulaire=0;
            header("Refresh: 3 ; url=connexion.php");
        
        }
    }
} ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="css/autrespages.css">
</head>
<body>
    
<header> 

    <h1 id="titre_header2" data-text="Module de connexion"> Module de connexion </h1>
    <div id="titre_header"><h4> Valentin MATHIEU </h4></div>
    <div>

</header>
<main> <?php
if ($AfficherFormulaire==1){ ?>

    <div class="erreurs">
        <?php if(isset($erreurlogin)) {echo $erreurlogin ;}
              if(isset($erreurprenom)) {echo $erreurprenom ;}
              if(isset($erreurnom)) {echo $erreurnom ;}
              if(isset($erreurpass)) {echo $erreurpass ;}
              if(isset($erreurpassconf)) {echo $erreurpassconf ;}
        ?>
    </div>
    <br>
    <form class="form" method="post" action="inscription.php"> 
        <h1 id="titre_form"> Formulaire d'inscription </h1>  
        <br>
        <label for="login"> Login : </label>
        <input type="text" name="login">
        <br>
        <label for="prenom"> Prénom : </label>
        <input type="text" name="prenom">
        <br>
        <label for="nom"> Nom : </label>
        <input type="text" name="nom">
        <br>
        <label for="password"> Mot de passe : </label> 
        <input type="password" name="password">
        <br>
        <label for="password_confirm"> Confirmer votre mot de passe : </label>
        <input type="password" name="password_confirm">
        <br>
        <div class="bouton">
        <button class="bouton_form" type="submit">S'inscrire !</button>
        </div>
    </form>
<?php } ?>

    <section class="messages">
        <?php if (isset($validinscrip)) {echo $validinscrip;} ?>
    </section>

    <section class="messages">
        <?php if (isset($erreur)) {echo $erreur;} ?>
    </section>

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