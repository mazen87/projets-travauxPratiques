<?php
    session_start();
    require_once 'connexionbdd.php';
    mysqli_set_charset($link, "utf8");
    if(empty($_SESSION['idtech'])){
        header("Location: http://gestionticket/connexion_utilisateur.php");
        exit();
    }else{
        //déclrer les variables 
        $tickets = [];
        $erreurs = [];
        $statuts_ticket = ["nouveau","encours","terminé","all"];
        $requete_tous_ticket = "";
        $statut_ticket_choisi = "";
        $num_ticket_nouveau = "";
        $num_ticket_encours = "";
        $num_ticket_termine = "";
        $erreurs_tableau_bord = [];

        //traiter le formulaire de recherche : 
        if(isset($_POST['filtrer'])){
            if(!empty($_POST['statut_ticket'])){
                //récupérer le statut choisi 
                $statut_ticket_choisi = $_POST['statut_ticket'];
                
            }
            
        //choisir la bon requête de select toutes tickets 
        if(!empty($statut_ticket_choisi)){
            if($statut_ticket_choisi == "all"){
                //préparer la requête 
        $requete_tous_ticket = "select t.id as id_ticket , t.titre as titre_ticket,t.message_ticket as message_ticket,t.statut_ticket,
        u.id as id_utilisateur ,u.nom as createur_ticket,c.nom_cat from utilisateur u   join ticket t  on t.id_utilisateur = u.id  
        join categorie c on c.id = t.id_categorie ORDER by t.date ASC";
            }else{
                $requete_tous_ticket ="select t.id as id_ticket , t.titre as titre_ticket,t.message_ticket as message_ticket,t.statut_ticket,
                u.id as id_utilisateur ,u.nom as createur_ticket,c.nom_cat from utilisateur u   join ticket t  on t.id_utilisateur = u.id  
                join categorie c on c.id = t.id_categorie where t.statut_ticket = '$statut_ticket_choisi' ORDER by t.date ASC";
            }
        }

              //récupérer tous les tickets 
        
        //exécuter la requête 
        $resultat = mysqli_query($link,$requete_tous_ticket);

        if($resultat){
            while($ligne_resultat_ticket = mysqli_fetch_assoc($resultat)){
                $tickets[] = $ligne_resultat_ticket;
            }
        }else{
            $erreurs [] = "aucun ticket trouvé ou erreur de connexion .....!";
        }


        }else{

              //préparer la requête 
              $requete_tous_ticket = "select t.id as id_ticket , t.titre as titre_ticket,t.message_ticket as message_ticket,t.statut_ticket,
                u.id as id_utilisateur ,u.nom as createur_ticket,c.nom_cat from utilisateur u   join ticket t  on t.id_utilisateur = u.id  
                join categorie c on c.id = t.id_categorie ORDER by t.date ASC";

                 //exécuter la requête 
        $resultat = mysqli_query($link,$requete_tous_ticket);

        if($resultat){
            while($ligne_resultat_ticket = mysqli_fetch_assoc($resultat)){
                $tickets[] = $ligne_resultat_ticket;
            }
        }else{
            $erreurs [] = "aucun ticket trouvé ou erreur de connexion .....!";
        }
        }

        //récupérer les statistiques de tickets pour le tableau de bord assistant
        
            //préparer les requêtes :
            //requête ticket nouveau :  
            $requete_ticket_nouveau = "select count(ticket.id) as num_ticket_nouveau from ticket where ticket.statut_ticket like 'nouveau'";
            //exécuter la requête 
            $resultat1 = mysqli_query($link,$requete_ticket_nouveau);
            $ligne_resultat1 = mysqli_fetch_assoc($resultat1);
            $num_ticket_nouveau = $ligne_resultat1['num_ticket_nouveau'];

             //requête ticket encours :  
             $requete_ticket_encours = "select count(ticket.id) as num_ticket_encours from ticket where ticket.statut_ticket like 'encours'";
             //exécuter la requête 
             $resultat2 = mysqli_query($link,$requete_ticket_encours);
             $ligne_resultat2 = mysqli_fetch_assoc($resultat2);
             $num_ticket_encours = $ligne_resultat2['num_ticket_encours'];

             //requête ticket terminé :  
             $requete_ticket_termine = "select count(ticket.id) as num_ticket_terminé from ticket where ticket.statut_ticket like 'terminé'";
             //exécuter la requête 
             $resultat3 = mysqli_query($link,$requete_ticket_termine);
             $ligne_resultat3 = mysqli_fetch_assoc($resultat3);
             $num_ticket_termine = $ligne_resultat3['num_ticket_terminé'];

      

        
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
        <h1> Gestion de Tickets</h1>

        <h3>Accueil Technicien</h3>
        <form method="POST">
            <label>Filtrer les tickes par statut :  </label><select name="statut_ticket">
            <?php
                for($i=0;$i<count($statuts_ticket);$i++){
                    ?>
                    <option value="<?=$statuts_ticket[$i]?>"><?=$statuts_ticket[$i]?> </option>
            <?php
                }
            ?>
            </select>
            <input type="submit" value="filtrer" name="filtrer"/>
        </form>
        <ul>
            <?php 
                for($i=0;$i<count($erreurs);$i++){
                    echo "<li>".$erreurs[$i]."</li>";
                }
            ?>
            </ul>
           <?php      
            if(!empty($tickets)){
                ?>
                <table>
                    <tr>
                        <th>Titre de ticket</th><th>message de ticket</th><th>statut du ticket</th><th>nom de créateur de ticket</th><th>Catégorie</th>
                        <th></th><th></th><th></th>
                    </tr>
                    <?php
                    for($i = 0;$i<count($tickets);$i++){
                        if($tickets[$i]['statut_ticket']== "terminé"){
                            ?>
                            <tr>
                            <td><?=$tickets[$i]['titre_ticket']?></td>
                            <td><?=$tickets[$i]['message_ticket']?></td>
                            <td><?=$tickets[$i]['statut_ticket']?></td>
                            <td><?=$tickets[$i]['createur_ticket']?></td>
                            <td><?=$tickets[$i]['nom_cat']?></td>
                            <td><a href="/modifier_categorie.php?id_ticket=<?=$tickets[$i]['id_ticket']?>&titre_ticket=<?=$tickets[$i]['titre_ticket']?>&message_ticket=<?=$tickets[$i]['message_ticket']?>&nom_cat=<?=$tickets[$i]['nom_cat']?>"> modifier la catégorie /  </a></td>
                            <td><a href="/modifier_statut_ticket.php?id_ticket=<?=$tickets[$i]['id_ticket']?>&titre_ticket=<?=$tickets[$i]['titre_ticket']?>&message_ticket=<?=$tickets[$i]['message_ticket']?>&nom_cat=<?=$tickets[$i]['nom_cat']?>&statut_ticket=<?=$tickets[$i]['statut_ticket']?>">Modifier le statut du ticket</a></td>
                        </tr>
                        <?php    
                        }else{
                            ?>
                            <tr>
                                <td><?=$tickets[$i]['titre_ticket']?></td>
                                <td><?=$tickets[$i]['message_ticket']?></td>
                                <td><?=$tickets[$i]['statut_ticket']?></td>
                                <td><?=$tickets[$i]['createur_ticket']?></td>
                                <td><?=$tickets[$i]['nom_cat']?></td>
                                <td><a href="/nouvelle_reponse.php?id_ticket=<?=$tickets[$i]['id_ticket']?>">répondre /</a></td>
                                <td><a href="/modifier_categorie.php?id_ticket=<?=$tickets[$i]['id_ticket']?>&titre_ticket=<?=$tickets[$i]['titre_ticket']?>&message_ticket=<?=$tickets[$i]['message_ticket']?>&nom_cat=<?=$tickets[$i]['nom_cat']?>"> modifier la catégorie /  </a></td>
                                <td><a href="/modifier_statut_ticket.php?id_ticket=<?=$tickets[$i]['id_ticket']?>&titre_ticket=<?=$tickets[$i]['titre_ticket']?>&message_ticket=<?=$tickets[$i]['message_ticket']?>&nom_cat=<?=$tickets[$i]['nom_cat']?>&statut_ticket=<?=$tickets[$i]['statut_ticket']?>">Modifier le statut du ticket</a></td>
                            </tr>
                            <?php
                        }
                       
        
                    }
            }
            ?>
                </table>
                <script>
                    function tableauBord() {
                        alert("numéro des tickets nouveaux : <?=$num_ticket_nouveau?> \nnuméro des tickets encours : <?=$num_ticket_encours?> \nnuméro des tickets terminés : <?=$num_ticket_termine?>");
                    }

                </script>
                <form method="POST">
                    <input type="submit" value="tableau de bord assistant" name="tableau_bord" onclick="tableauBord()"/>
                </form>

                <form method="POST">
            <input type="submit"  value="deconnecter" name="deconnecter"/>
        </form>
    </body>
</html>