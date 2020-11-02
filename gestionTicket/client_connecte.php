<?php
    session_start();
    if(!empty($_SESSION['idClient'])){
    require_once 'connexionbdd.php';
    mysqli_set_charset($link, "utf8");

    //déclarer les variables
    $recherche = "";
    $erreurs = [];
    $resultat_tickets = [];
    if(isset($_POST['rechercher'])){
        if(!empty($_POST['saisie'])){
            $recherche = htmlspecialchars(trim(stripslashes(strip_tags($_POST['saisie']))));
        }else{
            $erreurs[] = "la zone de recherche est vide.....!";
        }

        //rechrcher un ticket par son numéro aléatoire ou par l'email de l'utilisateur connecté
        if(empty($erreurs)){
            //préparer la requête 
            $requete_recherche_ticket = "select t.titre,t.message_ticket as message,t.statut_ticket ,t.id as id_ticket , t.date, u.nom as nom_createur , u.statut as statut_createur from ticket t JOIN utilisateur u on u.id = t.id_utilisateur where u.email like '$recherche' or t.num_alea like '$recherche' and u.id =".$_SESSION['idClient'].";";
            //exécuter la requête 
            $resultat_recherche_ticket = mysqli_query($link,$requete_recherche_ticket);
            if($resultat_recherche_ticket){
                while($ligne_resultat_recherche_ticket = mysqli_fetch_assoc($resultat_recherche_ticket)){
                    $resultat_tickets[] = $ligne_resultat_recherche_ticket;
                 
                }
            }else {
                $erreurs[] = "aucun ticket trouvé ou erreur de connexion à la base de données";
            }
        } 
    }


     //traiter le formulaire de déconnexion 
     if(isset($_POST['deconnecter'])){
        session_destroy();
        header("Location: http://gestionticket/connexion_utilisateur.php");
        exit();
    }

}else{
    header("Location: http://gestionticket/connexion_utilisateur.php");
    exit();
}

?>
<html>
    <head>
    </head>
    <body>
        <h1>Gestion des Tickets</h1>
        
            <h3>Accueil Client</h3>
            <ul>
            <?php 
                for($i=0;$i<count($erreurs);$i++){
                    echo "<li>".$erreurs[$i]."</li>";
                }
            ?>
            </ul>
            <?php 
            // afficher les tickets trouvés 
            if(!empty($resultat_tickets)){
                ?>
                <table>
                    <tr>
                        <th>Titre</th><th>message</th><th>date</th><th>statut</th><th>nom de créateur</th>
                    </tr>
                    <?php
                for($i=0; $i<count($resultat_tickets);$i++){
                    if($resultat_tickets[$i]['statut_ticket'] == "terminé"){
                        ?>
                     <tr><td><?=$resultat_tickets[$i]['titre']?></td><td><?=$resultat_tickets[$i]['message']?></td>
                        <td><?=$resultat_tickets[$i]['date']?></td><td><?=$resultat_tickets[$i]['statut_ticket']?></td><td><?=$resultat_tickets[$i]['nom_createur']?></td>
                    </tr>    
                    <?php
                    }else{
                        ?>
                        <tr><td><?=$resultat_tickets[$i]['titre']?></td><td><?=$resultat_tickets[$i]['message']?></td>
                        <td><?=$resultat_tickets[$i]['date']?></td><td><?=$resultat_tickets[$i]['statut_ticket']?></td><td><?=$resultat_tickets[$i]['nom_createur']?></td>
                        <td><a href="/nouvelle_reponse.php?id_ticket=<?=$resultat_tickets[$i]['id_ticket']?>">Répondre</a></td>
                    </tr>
                    <?php
                    }
                    ?>
                   
                    <?php

                        }
                     }
                    ?> 
                </table>    
           


            <form method="POST">
            <input type="text" placeholder="email ou numéro de ticket aléatoire ....." size="35" name="saisie"/>
            <input  type="submit" value="Rechercher" name="rechercher"/>
            </form>
            <a href="/nouveau_ticket.php">Créer un nouveau Ticket</a>
            <form method="POST">
            <input type="submit"  value="deconnecter" name="deconnecter"/>
        </form>
    </body>
</html>