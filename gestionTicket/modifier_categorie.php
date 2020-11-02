<?php
    session_start();
    require_once 'connexionbdd.php';
    mysqli_set_charset($link, "utf8");
    if(empty($_SESSION['idtech'])){
        header("Location: http://gestionticket/connexion_utilisateur.php");
        exit();
    }else{
        //déclaration des variables 
        $categeories = [];
        $erreurs = [];
        $id_cat = 0;
        $id_ticket = 0;

        //récopérer toustes les catégories 
        //préparation de la requête 
        $requete_toutes_categories = "select * from categorie ";
        //exécuter la requête 
        $resultat = mysqli_query($link,$requete_toutes_categories);
        if($resultat){
            while($ligne_resultat_toutes_categorie = mysqli_fetch_assoc($resultat)){
                $categeories[] = $ligne_resultat_toutes_categorie;
            }
        }else{
            $erreurs[] = "aucune catégorie existe ou erreur de connexion";
        }


        //traiter le formulaire de modification de catégorie 

        if(isset($_POST['id_cat'])){
            $id_cat = intval($_POST['id_cat']);
        }
        if(isset($_POST['modifier'])){
            //préparation de la requête 
            if(!empty($_GET['id_ticket'])){
                $id_ticket = $_GET['id_ticket'];
            $requete_mdifier_categorie = " UPDATE ticket SET id_categorie = '$id_cat' where id ='$id_ticket';";
            //exécuter la requête 
            $resultat = mysqli_query($link,$requete_mdifier_categorie);
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
        <h3>Modifier la categorie</h3>

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
            <select name="id_cat">
                <?php
                 for($i=0;$i<count($categeories);$i++){
                     if(!empty($_GET['nom_cat'])){
                         if($categeories[$i]['nom_cat'] == $_GET['nom_cat']){
                             ?>
                              <option value="<?=$categeories[$i]['id']?>" selected><?=$categeories[$i]['nom_cat']?></option>
                              <?php
                         }else{
                             ?>
                              <option value="<?=$categeories[$i]['id']?>" ><?=$categeories[$i]['nom_cat']?></option>
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