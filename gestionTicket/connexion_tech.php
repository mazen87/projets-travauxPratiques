<?php
    session_start();
    require_once 'connexionbdd.php';
    mysqli_set_charset($link, "utf8");

    //mot de passe technicien 
    $motDePasseTech = "technicien";

    //déclarer les variables 
    $motDePasse = "";
    $erreurs = [];
    if(isset($_POST['connecter'])){
        if(!empty($_POST['motpassetech'])){
            $motDePasse = $_POST['motpassetech'];
        }else{
            $erreurs[] = "mot de passe est vide ...";
        }

        // tester le mot de passe 
        if($motDePasse == $motDePasseTech){
            header("Location: http://gestionticket/accueil_tech.php");
            exit();
        }
    }

    //traiter le formulaire de déconnexion 
    if(isset($_POST['deconnecter'])){
        session_destroy();
        header("Location: http://gestionticket/connexion_utilisateur.php");
        exit();
    }

?>
<html>
    <head>
    </head>
    <body>
        <h1>Gestion des Tickets</h1>
        <ul>
        <?php
        for ($i=0;$i< count($erreurs);$i++){
        echo "<li>".$erreurs[$i]."</li>";
    }
        ?>
        </ul>
        <form method="POST">
            <h3>connexion technicien</h3>
            <input type="password" placeholder="mot de passe " name="motpassetech"/>
            <input type="submit" value="se connecter" name="connecter"/>
        </form>

        <form method="POST">
            <input type="submit"  value="deconnecter" name="deconnecter"/>
        </form>
    </body>
</html>