<?php
     require_once 'connexionBDD.php';
     require_once 'message.php';
     require_once 'reponse.php';
     $connexionBDD = new Connexionbdd("localhost","root","","forum_anonyme");
    /**
     * déclaration de variables 
     */
    $contenu_message = "";
    $id_message = 0;
    $createur_message = "";
    $reponses_message = array();
    $nombre_likes = 0;
    $nombre_dislikes =0;
    $erreurs = array();
    $erreurs_reponse = array();
    $createur_reponse = $_SERVER['REMOTE_ADDR'];
    $reponse = new Reponse();
    $reussi = "";
    /**
     * assainir les variables
     */
    if(!empty($_GET['id_message'])){
        $id_message = intval($_GET['id_message']);
    }else{
        $erreurs[] = "accès interdit à la page .....";
    }
    if(!empty($_GET['contenu'])){
        $contenu_message = $_GET['contenu'];
    }
    if(!empty($_GET['createur'])){
        $createur_message = $_GET['createur'];
    }
    if(!empty($_GET['nombre_likes'])){
        $nombre_likes = $_GET['nombre_likes'];
    }
    if(!empty($_GET['nombre_dislikes'])){
        $nombre_dislikes = $_GET['nombre_dislikes'];
    }

    if(empty($erreurs)){
        /**
         * créer une novelle réponse 
         * préparer l'objet réponse 
         */
       
        if(isset($_POST['repondre'])){  
            if(!empty($_POST['contenu_reponse'])){
                $reponse->set_contenu_reponse(htmlspecialchars(trim(stripslashes(strip_tags($_POST['contenu_reponse'])))));
            }else{
                $erreurs_reponse[]= "la zone de saisi est vide ......"; 
            }
            $reponse->set_createur_reponse($createur_reponse);
            $reponse->set_id_message($id_message);
        
        /**
         * préparer la requête 
         */
        if(empty($erreurs_reponse)){
        $requet_insertion_reponse = "INSERT INTO reponse (contenu_reponse,id_message,createur_reponse) VALUES (?,?,?)";
        $stmt = $connexionBDD->connexion->prepare($requet_insertion_reponse);
        $stmt->bind_param("sis",$p_contenu_reponse,$p_id_message,$p_createur_reponse);
        $p_contenu_reponse = $reponse->get_contenu_reponse();
        $p_id_message = $reponse->get_id_message();
        $p_createur_reponse = $reponse->get_createur_reponse();
        $stmt->execute();
        $reponse->set_id($connexionBDD->connexion->insert_id);

        if($reponse->get_id() != 0){
            $reussi = "insertion réussie....";
        }else{
            $erreurs_reponse[] = "insertion échouée ou erreur de connexion à la BDD....";
        }
        header("Location: repondre.php?id_message=$id_message&contenu=$contenu_message&createur=$createur_message&nombre_likes=$nombre_likes&nombre_dislikes=$nombre_dislikes");
        exit();
    }
    }
        /**
     * récupérer toutes les réponses de la message choisie depuis la BDD 
     */
    /**
     * préparer la requête
     */
        $requete_select_reponses = "SELECT id,contenu_reponse,date_reponse,id_message,createur_reponse FROM reponse WHERE id_message= ? ORDER BY date_reponse DESC";
        $stmt = $connexionBDD->connexion->prepare($requete_select_reponses);
        $stmt->bind_param("i",$p_id_message);
        $p_id_message = $id_message;
        $stmt->execute();
        $stmt->bind_result($r_id_reponse,$r_contenu_reponse,$r_date_reponse,$r_id_message,$r_createur_reponse);
        while($stmt->fetch()){
            $reponses_message[] = Reponse::construct_rempli($r_id_reponse,$r_contenu_reponse,$r_date_reponse,$r_id_message,$r_createur_reponse);
        }

    }
 

?>
<!--rendu-->
<html>
    <head>
        <script src="jquery-3.5.1.min.js"></script>
        <script>
          
            $(function(){
                var nombre_likes = $("#nombre_likes").val();
                var nombre_dislikes  = $("#nombre_dislikes").val();
                var id_message = $("#id_message").val();
                var like_disabled = $("#like").is("disabled");
                var dislike_disabled = $("dislike").is("disabled");
                console.log(like_disabled);
                console.log(dislike_disabled);
                
                //console.log(nombre_likes);
                //console.log(nombre_dislikes);
                //console.log(id_message);
                $("#like").click(function(){
                        $.ajax({
                            url : "like.php",
                            data : {
                                likes_nombre : nombre_likes,
                                dislikes_nombre : nombre_dislikes,
                                message_id : id_message,
                                disabled_like : like_disabled,
                                disabled_dislike : dislike_disabled
                            },
                            method : "POST",
                            dataType : "JSON"
                        }).done(function(donnes){
                            $("#retour_like").val(donnes.nouveau_nombre_likes);
                            if(donnes.nouveau_nombre_dislikes != null){
                                $("#retour_dislike").val(donnes.nouveau_nombre_dislikes);
                            }
                            $("#like").prop('disabled',true);

                        });
                });

               

            });

        </script>
    </head>
    <body>
        <h1>Forum anonyme</h1>
        <ul>
        <?php // parcourir dans le tableau d'erreurs pour les afficher
           if(!empty($erreurs_reponse)){     
            for($i=0;$i<count($erreurs_reponse);$i++){
        ?>
        <li><?php echo $erreurs_reponse[$i];?></li>        
        <?php
            }
        } 
        ?>
        </ul>
        <?php
        if(!empty($reussi)){
            echo $reussi;
        }
        ?>
        <input type="hidden" id="id_message" value="<?=$id_message?>"/>
        <input type="hidden" id="nombre_likes" value="<?=$nombre_likes?>"/>
        <input type="hidden" id="nombre_dislikes" value="<?=$nombre_dislikes?>"/>
        <label>Message : </label><span><?php echo $contenu_message?></span><br>
        <label>Créateur : </label><span ><?php echo $createur_message?></span><br>
        <label>nombre de likes : </label><span  id="retour_like"><?php echo $nombre_likes?></span><br>
        <label>nombre de dislikes : </label><span  id="retour_dislike"><?php echo $nombre_dislikes?></span><br>
        <button id="like" name="like">Like</button> <button id="dislike" name="dislike">Dislike</button>
        <h2>Liste de Réponses</h2>
        <?php 
        if(count($reponses_message)!=0){
    ?>
    <table> 
        <tr>
            <th>Contenu de réponse</th><th>Créateur de réponse</th>
        </tr>
    <?php
        for($i=0;$i<count($reponses_message);$i++){
    ?>
        <tr>
            <td><?=$reponses_message[$i]->get_contenu_reponse()?></td>
            <td><?=$reponses_message[$i]->get_createur_reponse()?></td>
        </tr>   
    <?php     
        }            
        }
    ?>
    </table>
    <form method="POST">
        <textarea name="contenu_reponse" placeholder="votre réponse ici ...."></textarea>
        <input type="submit" value="Répondre"  name="repondre"/>
    </form>
    <a href="index.php">Retour</a>
    </body>
</html>