<?php
    session_start();
    require_once 'connexionbdd.php';
    mysqli_set_charset($link, "utf8");
    if(empty($_SESSION['idClient']) && empty($_SESSION['idtech'])){ // accés  direct interdit à la page pour l'utilisateur non connecté 
        header("Location: http://gestionticket/connexion_utilisateur.php");
        exit();
        
    }else{
        //déclarer les variables
        $message = "";
        $erreurs = [];
        $id_ticket =0;
        $id_utilisateur = 0;
        $information_ticket_choisi= "";
        $message_insertion_reponse_reussite = "";
        $reponses = [];

        
        if(!empty($_GET['id_ticket'])){

            $id_ticket = $_GET['id_ticket'];
        }

        if(!empty($_SESSION['idClient'])){
            $id_utilisateur = $_SESSION['idClient'];
        }else{
            $id_utilisateur = $_SESSION['idtech'];
        }

        if(isset($_POST['message_reponse']) ){
            $message = htmlspecialchars(trim(stripslashes(strip_tags($_POST['message_reponse']))));
        }
            //assainir les variables 
            if(isset($_POST['reponse'])){
            if(empty($_POST['message_reponse'])){
                $erreurs[] = "la message est vide....!";

            }
             //insertion d'une nouvelle réponse 
            if(empty($erreurs) ){
                //préparer la requête
                $requete_insertion_reponse = "INSERT INTO reponse (message_reponse,id_ticket,id_utilisateur) VALUES ('$message','$id_ticket','$id_utilisateur')";
                //exécuter la requête 
                mysqli_query($link,$requete_insertion_reponse);
                $id_reponse_inseree = mysqli_insert_id($link);
                if($id_reponse_inseree != 0){
                    $message_insertion_reponse_reussite = "insertion réussite...!";
                    //changer le statut du ticket en encours 
                    //préparation de requête
                    $requete_modifier_statut_reponse = "UPDATE ticket set statut_ticket = 'encours' where id = '$id_ticket' ";
                    mysqli_query($link,$requete_modifier_statut_reponse);
                     //Eviter le repost
                     header("Location: nouvelle_reponse.php?id_ticket=$id_ticket"); die;

                   
                }else{
                    $erreurs[] = "insertion échouée....!";
                }


              
            }

            }
           
                  
        //afficher l'information du ticket choisi 
        //préparer la requete 
        $requete_select_ticket_choisi = "select r.message_reponse, t.message_ticket,t.titre,u.nom as createur_reponse, u.statut as statut_createur_reponse from ticket t RIGHT join reponse r on r.id_ticket = t.id join utilisateur u on u.id = r.id_utilisateur where t.id ='$id_ticket' order by r.date asc ";
        //exécuter la requête 
        $resultat = mysqli_query($link,$requete_select_ticket_choisi);
 
        if($resultat){
            while($ligne_resultat_reponse = mysqli_fetch_assoc($resultat) ){
            //récupérer l'information du ticket choisi 
            $reponses[] = $ligne_resultat_reponse;
        }
        }else{
            $erreurs[] = "aucun reponse existe pour ce ticket ou erreur de connexion...!";
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
        <h3>Nouvelle réponse</h3>
        <ul>
            <?php 
                for($i=0;$i<count($erreurs);$i++){
                    echo "<li>".$erreurs[$i]."</li>";
                }
            ?>
            </ul>
            <?php 
            if(!empty($message_insertion_reponse_reussite)){
                echo $message_insertion_reponse_reussite;
            }
            ?>

            <?php 
                if(!empty($reponses)){
                    ?>
                    <br><h3><strong>Titre de Ticket :</strong><?=$reponses[0]['titre']?></h3>
                    <h3><strong>message de Ticket :</strong><?=$reponses[0]['message_ticket']?></h3>
                    <h4>Liste de réponses : </h4>

                    
                     <table>
                    <tr>
                        <th>nom de créateur de réponse /  </th><th>statut de créateur de réponse  /</th><th>message de réponse</th>
                    </tr>
                    <?php
                for($i=0; $i<count($reponses);$i++){
                    ?>
                    <tr><td><?=$reponses[$i]['createur_reponse']?></td><td><?=$reponses[$i]['statut_createur_reponse']?></td>
                        <td><?=$reponses[$i]['message_reponse']?></td>
                    </tr>
                    <?php

                        }
                     }
                    ?> 
                </table>   
                   
    <form method="POST">
        <textarea placeholder="votre réponse ici.....!" name="message_reponse"></textarea>
        <input type="submit" value="Répondre" name="reponse"/>
    </form>
    <form method="POST">
            <input type="submit"  value="deconnecter" name="deconnecter"/>
        </form>
        <?php
            if(!empty($_SESSION['idClient'])){
                ?>
            <button><a href="/client_connecte.php">retour</a></button>
            <?php

            }else{
                ?>
                <button><a href="/accueil_tech.php">retour</a></button>
            <?php
            }
            ?>
        
    </body>
</html>