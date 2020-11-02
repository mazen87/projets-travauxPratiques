<?php
    session_start();
    require_once 'connexionbdd.php';
    mysqli_set_charset($link, "utf8");
    if(empty($_SESSION['idtech'])){
        header("Location: http://gestionticket/connexion_utilisateur.php");
        exit();
    }else{
        //déclaration des variables 
        $erreurs = [];
        $statuts_ticket = ["nouveau","encours","terminé"];
        $statut_ticket_choisi = "";
        $id_ticket = 0;


    //traiter le formulaire de la modificaion de statut de ticket 
    if(!empty($_GET['id_ticket'])){
        $id_ticket = intval($_GET['id_ticket']);
    }
    if(isset($_POST['modifier'])){
        //préparation de la requête 
        if(!empty($_POST['statut_ticket'])){
            $statut_ticket_choisi = htmlspecialchars(trim(stripslashes(strip_tags($_POST['statut_ticket']))));
        $requete_modifier_statut_ticket = "UPDATE ticket SET statut_ticket = '$statut_ticket_choisi' where id = '$id_ticket'";
        //exécuter la requête 
        $resultat = mysqli_query($link,$requete_modifier_statut_ticket);
        if($resultat != 0){
            header("Location: http://gestionticket/accueil_tech.php");
            exit();
        }else{
            $erreurs[] = "modification echouée ou erreur de connexion...!";
        }
    }
    }


       
    //traiter le formulaire de déconnexion 
     if(isset($_POST['deconnecter'])){
        session_destroy();
        header("Location: http://gestionticket/connexion_utilisateur.php");
        exit();
    }
    }

?>
<html>
    <head></head>
    <body>
    <h1>Gestion de Tickets</h1>
    <h3>Modifier le statut du ticket</h3>
    <ul>
            <?php 
                for($i=0;$i<count($erreurs);$i++){
                    echo "<li>".$erreurs[$i]."</li>";
                }
            ?>
            </ul>

            <?php
        if(!empty($_GET['titre_ticket'])&&!empty($_GET['message_ticket'])){
            ?>
             <br><h4><strong>Titre de Ticket :</strong><?=$_GET['titre_ticket']?></h4>
                 <h4><strong>message de Ticket :</strong><?=$_GET['message_ticket']?></h4>
        <?php    
        }
        ?>
        
        <form method="POST" >
            <select name="statut_ticket">
                <?php
                 for($i=0;$i<count($statuts_ticket);$i++){
                     if(!empty($_GET['statut_ticket'])){
                         if($statuts_ticket[$i] == $_GET['statut_ticket']){
                             ?>
                              <option value="<?=$statuts_ticket[$i]?>" selected><?=$statuts_ticket[$i]?></option>
                              <?php
                         }else{
                             ?>
                              <option value="<?=$statuts_ticket[$i]?>" ><?=$statuts_ticket[$i]?></option>
                              <?php
                         }

                         }
                     }
                ?>
               
               
            </select>
            <input type="submit" value="modifier" name="modifier"/>
        </form>
        <form method="POST">
            <input type="submit"  value="deconnecter" name="deconnecter"/>
        </form>
        <button><a href="/accueil_tech.php">retour</a></button>
    </body>
</html>