<?php
    
    session_start();
    require_once 'connexionBDD.php';
    require_once 'message.php';
    $connexionBDD = new Connexionbdd("localhost","root","","forumanonyme");
    /**
     * traiter le formulair d'ajout d'une nouvelle message 
     */
    if(empty($_SESSION['id_utilisateur'])){
        header("Location: index.php");
        exit();
    }else{
    $parametre_message = "";    
    $message = new Message(); 
    $erreurs = array(); // tableau d'erreurs
    $reussis = ""; //  messages de réussite 
    $messages = array();
    if(isset($_POST['creer_message'])){
        /**
         * préparer l'objet message 
         */
        /**
         * fonction pour valider les saisi contre l'injection java script et sql 
         */
        function validation_saisi ($saisi){
            $estValide = true;
            $caractereNonValide = array();
            $caractereNonValide [] = ["insert","alter","drop","create","delete","update","select","script"];
            for($i=0;$i<count($caractereNonValide);$i++){
                if(chr(strpos($saisi,$caractereNonValide[$i]) !== false)){
                    $estValide = false;
                }
            }
            return $estValide;
        }
      
        if(!empty($_POST['contenu_message'])){
            $message->set_contenu(trim(stripslashes(strip_tags($_POST['contenu_message'],'<span> <h1> <h2> <h3> <h4> <h5> <h6> <em> <strong>'))));
            //$message->set_contenu(trim(stripslashes(($_POST['contenu_message']))));
         

        }else{
            $erreurs[] = "la zone de saisi est vide ou des caractères non valides ont été trouvées.....!";
        }  
            $message->set_id_utilisateur(intval($_SESSION['id_utilisateur'])); // l'objet est prêt à insérer à la BDD 
        /**
         * préparer la  requête 
         *  */    
        if(empty($erreurs)){
            $requete_insertion_message = "INSERT INTO message (id_utilisateur,contenu) VALUES (?,?)";
            $stmt = $connexionBDD->connexion->prepare($requete_insertion_message);
            $stmt->bind_param("is",$p_id_utilisateur,$p_contenu);
            $p_id_utilisateur = $message->get_id_utilisateur();
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
             header("Location: accueil_utilisateur.php");
             exit();
        }
    }

    /**
     * afficher toutes les messages existant dans la BDD 
     */
    /**
     * préparer la requête 
     */
    //$requete_select_messages = "SELECT m.id,m.ip_utilisateur,m.contenu,m.nombre_likes,m.nombre_dislikes,m.date_creation, count(r.id) as nombre_reponses FROM message m LEFT JOIN  reponse r ON r.id_message = m.id GROUP BY m.contenu  ORDER BY m.date_creation DESC";
    $requete_select_toutes_messages = "SELECT m.id as id_message, m.contenu,m.id_utilisateur,COUNT(r.id) as nombre_reponses, m.date_creation,u.pseudo FROM utilisateur u RIGHT JOIN message m on m.id_utilisateur = u.id LEFT JOIN reponse r ON m.id = r.id_message GROUP BY m.contenu ORDER BY  m.date_creation DESC";
    $stmt = $connexionBDD->connexion->prepare($requete_select_toutes_messages);
    $stmt-> execute();
    //$stmt->bind_result($r_id,$r_ip_utilisateur,$r_contenu,$r_nombre_likes,$r_nombre_dislikes,$r_date_creation,$r_nombre_reponses);
    $stmt->bind_result($r_id_message,$r_contenu,$r_id_utilisateur,$r_nombre_reponses,$r_date_creation,$r_pseudo);
    while($stmt->fetch() ){
        //$messages[] = Message::construct_rempli_avec_nombre_reponses($r_id,$r_ip_utilisateur,$r_contenu,$r_nombre_likes,$r_nombre_dislikes,$r_date_creation,$r_nombre_reponses);
        $messages[] = Message::construct_rempli_avec_nombre_reponses($r_id_message,$r_id_utilisateur,$r_contenu,$r_date_creation,$r_nombre_reponses,$r_pseudo);
    }

      //traiter le formulaire de déconnexion 
      if(isset($_POST['deconnecter'])){
        session_destroy();
        header("Location: index.php");
        exit();
    }
    }
    
?>
<!-- rendu -->
<!DOCTYPE html>
<html>
    <head>
        <script src="jquery-3.5.1.min.js"></script>
        <script src="jquery-validation-1.19.2/dist/jquery.validate.js"></script>   
        <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
        <script>tinymce.init({
            selector:'textarea',
            width:"40%",
            height:"200px",
            });</script>
              <script>
            $(function(){
                $("#message").validate({
                    rules: {
                        contenu_message: {
                            required : true,
                            minlength : 3
                        }
                    }
                })
            });

        </script>
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
            <th>Message</th><th>Créateur de message</th><th>Nombre de réponses</th><!--<th>Nombre de likes</th><th>Nombre de dislikes</th>-->
        </tr>
    <?php
        for($i=0;$i<count($messages);$i++){
    ?>
        <tr>
            <td><?=$messages[$i]->get_contenu()?></td>
          
            <td><?=$messages[$i]->pseudo?></td>
            <td><?=$messages[$i]->get_nombre_reponses()?></td> 
         
            <td><a href='repondre.php?id_message=<?=$messages[$i]->get_id()?>&contenu=<?php echo $messages[$i]->get_contenu()?>&createur=<?=$messages[$i]->pseudo?>'>Répondre/like/dislike</a></td>
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
        <form method="POST" id="message"> <!-- formulaire pour ajouter une nouvelle message -->
            <textarea id="contenu_message" name="contenu_message" placeholder="votre message ici ......."></textarea>
            <input type="submit" value="Créer une message" name="creer_message"/>
        </form>
        <form method="POST">
            <input type="submit"  value="deconnecter" name="deconnecter"/>
        </form>
    </body>
</html>