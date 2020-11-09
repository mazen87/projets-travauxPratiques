<?php
    require_once 'connexionBDD.php';
    require_once 'message.php';
    $connexionBDD = new Connexionbdd("localhost","root","","forum_anonyme");
    /**
     * traiter le formulair d'ajout d'une nouvelle message 
     */
    $message = new Message(); 
    $erreurs = array(); // tableau d'erreurs
    $reussis = ""; //  messages de réussite 
    $messages = array();
    if(isset($_POST['creer_message'])){
        /**
         * préparer l'objet message 
         */
        if(!empty($_POST['contenu_message'])){
            $message->set_contenu(htmlspecialchars(trim(stripslashes(strip_tags($_POST['contenu_message'])))));
        }else{
            $erreurs[] = "la zone de saisi est vide.....!";
        }  
            $message->set_ip_utilisateur($_SERVER['REMOTE_ADDR']); // l'objet est prêt à insérer à la BDD 
        /**
         * préparer la  requête 
         *  */    
        if(empty($erreurs)){
            $requete_insertion_message = "INSERT INTO message (ip_utilisateur,contenu) VALUES (?,?)";
            $stmt = $connexionBDD->connexion->prepare($requete_insertion_message);
            $stmt->bind_param("ss",$p_ip_utilisateur,$p_contenu);
            $p_ip_utilisateur = $message->get_ip_utilisateur();
            $p_contenu = $message->get_contenu();
            /**
             * exécuter la requête 
             */
            $stmt->execute();
            $message->set_id($connexionBDD->connexion->insert_id);
            /**
             * tester si l'insrtion de la message a réussi ou pas 
             */
            if($message->get_id() != 0){
               
                $reussis = "insertion réussi ...."; // insertion réussi
            }else{
                $erreurs[] = "insertion échouée ou erreur de connexion ...."; // insertion échouée
            }
             header("Location: index.php");
             exit();
        }
    }

    /**
     * afficher toutes les messages existant dans la BDD 
     */
    /**
     * préparer la requête 
     */
    $requete_select_messages = "SELECT m.id,m.ip_utilisateur,m.contenu,m.nombre_likes,m.nombre_dislikes,m.date_creation, count(r.id) as nombre_reponses FROM message m LEFT JOIN  reponse r ON r.id_message = m.id GROUP BY m.contenu  ORDER BY m.date_creation DESC";
    $stmt = $connexionBDD->connexion->prepare($requete_select_messages);
    $stmt-> execute();
    $stmt->bind_result($r_id,$r_ip_utilisateur,$r_contenu,$r_nombre_likes,$r_nombre_dislikes,$r_date_creation,$r_nombre_reponses);
    while($stmt->fetch() ){
        $messages[] = Message::construct_rempli_avec_nombre_reponses($r_id,$r_ip_utilisateur,$r_contenu,$r_nombre_likes,$r_nombre_dislikes,$r_date_creation,$r_nombre_reponses);
    }

?>
<!-- rendu -->
<html>
    <head>
        <script src="jquery-3.5.1.min.js"></script>
        <script>
            /*
            $(function(){
                $("td #like_bouton").click(function(){
                    
                    var id_message = $(this).data("id_message");
                    var nombre_likes = $(this).data("nombre_likes");
                    var nombre_dislikes = $(this).data("nombre_dislikes");
                    var id_element = $(this).data("id_element");
                    var dislikeDecrement = null ;
                    console.log(id_element);
                   console.log(id_message);
                    console.log(nombre_likes);
                    console.log(nombre_dislikes);
                   if($("td #dislike_bouton").prop('disabled')==true){
                       dislikeDecrement = true;
                   }else{
                       dislikeDecrement = false;
                   }
                 });
                 
                   $.ajax({
                       url : "like.php",
                       data : {
                           id_message : id_message,
                           nombre_likes : nombre_likes,
                           nombre_dislikes : nombre_dislikes,
                           id_element : id_element,
                           dislikeDecrement : dislikeDecrement
                       },
                       method : "POST",
                       dataType : "JSON"
                   }).done(function(donnes){
                       $(this).$("#nombre_likes").val(donnes.num_likes);
                       $(this).$("#nombre_dislikes").val(donnes.num_dislikes);
                       $(this).$("td #like_bouton").prop("disabled",true);
                       
                   });
                
                   
            });
         */
        </script>
    </head>
    <body>
        <h1>Forum Anonyme</h1>
        <h2>Liste de messages</h2>
        <?php 
        if(count($messages)!=0){
    ?>
    <table> 
        <tr>
            <th>Message</th><th>Créateur de message</th><th>Nombre de réponses</th><th>Nombre de likes</th><th>Nombre de dislikes</th>
        </tr>
    <?php
        for($i=0;$i<count($messages);$i++){
    ?>
        <tr>
            <td><?=$messages[$i]->get_contenu()?></td>
            <td><?=$messages[$i]->get_ip_utilisateur()?></td>
            <td><?=$messages[$i]->get_nombre_reponses()?></td> 
            <td id="nombre_likes"><?=$messages[$i]->get_nombre_likes()?></td>
            <td id="nombre_dislikes"><?=$messages[$i]->get_nombre_dislikes()?></td>
            <td><a href="repondre.php?id_message=<?=$messages[$i]->get_id()?>&contenu=<?=$messages[$i]->get_contenu()?>&createur=<?=$messages[$i]->get_ip_utilisateur()?>&nombre_likes=<?=$messages[$i]->get_nombre_likes()?>&nombre_dislikes=<?=$messages[$i]->get_nombre_dislikes()?>">Répondre/like/dislike</a></td>
            <!--
            <td><button id="like_bouton" data-id_message="<?=$messages[$i]->get_id()?>" data-nombre_likes="<?=$messages[$i]->get_nombre_likes()?>"data-nombre_dislikes="<?=$messages[$i]->get_nombre_dislikes()?>" data-createur_message="<?=$messages[$i]->get_ip_utilisateur()?>" data-id_element =<?=$i+1?>>Like</button></td>
            <td><button id="dislike_bouton" data-id_message="<?=$messages[$i]->get_id()?>" data-nombre_likes="<?=$messages[$i]->get_nombre_likes()?>"data-nombre_dislikes="<?=$messages[$i]->get_nombre_dislikes()?>" data-createur_message="<?=$messages[$i]->get_ip_utilisateur()?>">Dislike</button></td>
        -->
        </tr>   
    <?php     
        }            
        }
    ?>
    </table>
        <ul>
        <?php // parcourir dans le tableau d'erreurs pour les afficher
           if(!empty($erreurs)){     
            for($i=0;$i<count($erreurs);$i++){
        ?>
        <li><?php echo $erreurs[$i];?></li>        
        <?php
            }
        } 
        ?>
        </ul>
        <?php
            if(!empty($reussis)){
                echo $reussis;
            }
        
        ?>
        <form method="POST"> <!-- formulaire pour ajouter une nouvelle message -->
            <textarea id="contenu_message" name="contenu_message" placeholder="votre message ici ......."></textarea>
            <input type="submit" value="Créer une message" name="creer_message"/>
        </form>
    </body>
</html>