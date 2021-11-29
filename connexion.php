<?php 

session_start();

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

if (isset($_POST['connexion'])){

    if (empty($_POST['login'])){

        $erreurlogin = "Le champ Login est vide.";

    }

    else {

        if (empty($_POST['password'])){

            $erreurpass = "Le champ Mot de passe est vide.";

        }

        else {

            $Login=$_POST['login'];
            $Password=$_POST['password'];
            $Requete= mysqli_query($mysqli, "SELECT * FROM utilisateurs WHERE login='".$_POST['login']."' AND password='".$_POST['password']."'");
            
            if (mysqli_num_rows($Requete)==0) {

                $erreurco = "Le pseudo ou le mot de passe est incorrect.";

            }

            else {

                if ($Login == "admin" && $Password =="admin"){
                    $_SESSION['login']=$Login;
                    $AfficherFormulaire=0;
                    $validco = "Vous êtes à présent connecté, redirection vers l'espace administrateur...";
                    header("Refresh: 3; url=admin.php");
                }

                else {
                    $_SESSION['login']=$Login;
                    $validco = "Vous êtes à présent connecté, redirection vers l'espace membre...";
                    $AfficherFormulaire=0;
                    header("Refresh: 3; url=profil.php");
                }

            }
        
        }
    }
} ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="css/autrespages.css">
</head>
<body>
    
<header> 

    <h1 id="titre_header2" data-text="Module de connexion"> Module de connexion </h1>
    <div id="titre_header"><h4> Valentin MATHIEU </h4></div>
    <div>

</header>
<main>
<?php if ($AfficherFormulaire==1){ ?>

    <div class="erreurs">
        <?php if(isset($erreurlogin)) {echo $erreurlogin ;}
              if(isset($erreurpass)) {echo $erreurpass ;}
              if(isset($erreurco)) {echo $erreurco;}
        ?>
    </div>

    <br>
    <form class="form" method="post" action="connexion.php">
        <h1 id="titre_form"> Formulaire de connexion </h1>
        <br>
        <label for="login"> Login : </label>
        <input type="text" name="login">
        <br>
        <label for="password"> Mot de passe : </label> 
        <input type="password" name="password">
        <br>
        <div class="bouton_co">
        <button class="bouton_form" type="submit" name="connexion"> Se connecter ! </button>
        </div>
    </form>
<?php } ?>

    <section class="messages">
        <?php if (isset($validco)) {echo $validco;} ?>
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