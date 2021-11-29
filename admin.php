<?php 

session_start();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace administrateur</title>
    <link rel="stylesheet" href="css/autrespages.css">
</head>
<body>
    
<header> 

    <h1 id="titre_header2" data-text="Module de connexion"> Module de connexion </h1>
    <div id="titre_header"><h4> Valentin MATHIEU </h4></div>
    <div>

</header>

<main> 
    
    <h1 id="titre_profil"> Espace Administrateur </h1> 

    <div class="erreurs">
        <?php if(isset($erreur)) {echo $erreur ;} ?>
    </div>

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

if (!isset($_SESSION['login'])) {

    $erreur = "Erreur : seul l'administrateur peut accéder à cette page";
    header("Refresh: 3; url=index.php");

}

if ($_SESSION['login'] !== "admin"){

    $erreur = "Erreur : seul l'administrateur peut accéder à cette page";
    header("Refresh: 3; url=index.php");

}

if (($_SESSION['login']) == 'admin') {

    $requete = mysqli_query($mysqli, "SELECT * FROM utilisateurs"); 

    echo "<table border='1' align='center'>
        <thead>
            <tr>
            <th>id</th>
            <th>login</th>
            <th>prénom</th>
            <th>nom</th>
            <th>password</th>
            </tr>
        </thead>";

    while ($row = mysqli_fetch_array($requete)){

        echo "<tbody>";
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['login'] . "</td>";
            echo "<td>" . $row['prenom'] . "</td>";
            echo "<td>" . $row['nom'] . "</td>";
            echo "<td>" . $row['password'] . "</td>";
            echo "</tr>";
            echo "</tbody>";

    }

    echo "</table>";

    if (isset($_POST['deconnexion'])) {

        session_destroy();
    
        header('Refresh: 0; url=index.php');
    
    }

} ?>

    <form action="admin.php" method='post'>
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
