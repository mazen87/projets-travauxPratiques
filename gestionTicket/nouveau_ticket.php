<?php
    session_start();
    
    if(!empty($_SESSION['idClient'])){
    require_once 'connexionbdd.php';
    mysqli_set_charset($link, "utf8");
        //déclaration des variables 
        $titre = "";
        $message = "";
        //générer numéro aléatoire 
        $num =0;
        $num = rand(10000000,99999999);
        $numAlea = strval($num);
        
        $id_cat = 0;
        $id_client = intval($_SESSION['idClient']);
        $erreurs = [];
        $reussis =[];
        $insrtion_echoue = "";
        
        if(isset($_POST['creer'])){
            //vérifier les saisies et assainir les variable 
            if(!empty($_POST['titre'])){
                $titre = htmlspecialchars(trim(stripslashes(strip_tags($_POST['titre']))));
            }else{
                $erreurs[] = "titre est vide...!";
            }

            if(!empty($_POST['message'])){
                $message = htmlspecialchars(trim(stripslashes(strip_tags($_POST['message']))));
            }else{
                $erreurs[] = "message est vide...!";
            }

            if(!empty($_POST['numAlea'])){
                $numAlea = htmlspecialchars(trim(stripslashes(strip_tags($_POST['numAlea']))));
            }else{
                $erreurs[] = "numéro aléatoire est vide...!";
            }
            //récupérer l'id de la catégorie choisie
            $id_cat = intval($_POST['cat']);
           
            //insertion un nouveau ticket à la base de données 
 
            if(empty($erreurs)){
                
            //préparer la requête 
            $requete_insertion_ticket = "INSERT INTO ticket (titre,num_alea,message_ticket,id_categorie,id_utilisateur) VALUES ('$titre','$numAlea','$message','$id_cat','$id_client')";
            //exécuter la requête 
            mysqli_query($link,$requete_insertion_ticket);
            $id_nouveau_ticket = mysqli_insert_id($link);
            if($id_nouveau_ticket != 0){
                $reussis[] = "Insertion réussite.....!";
            }else {
                $insrtion_echoue = "insertion echouée ou numéro aléatoire déja utilisé.....!";
            }
        }

        }



             //traiter le formulaire de déconnexion 
     if(isset($_POST['deconnecter'])){
        session_destroy();
        header("Location: http://gestionticket/connexion_utilisateur.php");
        exit();
    }

    // accés  direct interdit à la page pour l'utilisateur non connecté 
    }else{
        header("Location: http://gestionticket/connexion_utilisateur.php");
        exit();
    }
?>
<html>
    <head></head>
    <body>
        <h1>Gestion de Tickets</h1>
        <h3> nouveau ticket</h3>
        <ul>
            <?php 
              for($i=0;$i<count($erreurs);$i++){
                echo "<li>".$erreurs[$i]."</li>";
            }
            ?>
        </ul>
        <ul>
            <?php 
              for($i=0;$i<count($reussis);$i++){
                echo "<li>".$reussis[$i]."</li>";
            }
            ?>
        </ul>
        <?php 
        if (!empty($insrtion_echoue)){
            echo $insrtion_echoue;
        }
        ?>

      
        <form method="POST">
            <input type="text" placeholder="titre" name="titre" />
            <input type="text" value="<?=$numAlea?>" name="numAlea" placeholder="numéro aléatoire"/>
            <textarea placeholder="votre message...." name="message"></textarea>
            <select name="cat">
                <option value="1">catégrie 1</option>
                <option value="2">catégrie 2</option>
                <option value="3">catégrie 3</option>
                <option value="4" selected>Autre</option>

            </select>
            <input type="submit" value="Créer" name="creer"/>
        </form>
        <button><a href="/client_connecte.php">retour</a></button>
        <form method="POST">
            <input type="submit"  value="deconnecter" name="deconnecter"/>
        </form>
    </body>
</html>