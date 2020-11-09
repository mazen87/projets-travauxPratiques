<?php
   require_once 'connexionBDD.php';
   require_once 'message.php';
   require_once 'reponse.php';
   $connexionBDD = new Connexionbdd("localhost","root","","forum_anonyme");

    if(!empty($_POST)){
        /**
         * récupérer les données arrivant en ajax 
         */
        $nombre_likes =0;
        $nombre_dislikes =0;
        $id_message =0;
        $like_disables = false;
        $dislike_disables = false;
        $nombre_likes_modifie =0;
        $nombre_dislikes_modifie =0;
        $resultat = array();

        /**
         * assainir les variables 
         */
        if(!empty($_POST['likes_nombre'])){
            $nombre_likes = intval($_POST['likes_nombre']);
        }
        if(!empty($_POST['dislikes_nombre'])){
            $nombre_dislikes = intval($_POST['dislikes_nombre']);
        }
        if(!empty($_POST['message_id'])){
            $id_message = intval($_POST['message_id']);
        }
        if(!empty($_POST['disabled_like'])){
            $like_disables = intval($_POST['disabled_like']);
        }
        if(!empty($_POST['disabled_dislike'])){
            $dislike_disables = intval($_POST['disabled_dislike']);
        }

        if($dislike_disables){
            $requete = "UPDATE message SET nombre_likes =?,nombre_dislikes =? where id =? ";
            $stmt = $connexionBDD->connexion->prepare($requete);
            $stmt->bind_param("iii",$p_nombre_likes,$p_nombre_dislikes,$p_id_message);
            $nombre_dislikes_modifie = $nombre_dislikes-1;
            $nombre_likes_modifie = $nombre_likes+1;
            $p_nombre_likes = $nombre_likes_modifie;
            $p_nombre_dislikes = $nombre_dislikes_modifie;
            $p_id_message = $id_message;

            /**
             * exécuter la requête 
             */
            $stmt->execute();
            $resultat[]=array("nouveau_nombre_likes"=>$nombre_likes_modifie,"nouveau_nombre_dislikes"=>$nombre_dislikes_modifie);
            echo json_encode($resultat);
            

        }else{
            $requete = "UPDATE message SET nombre_likes =? where id =? ";
            $stmt = $connexionBDD->connexion->prepare($requete);
            $stmt->bind_param("ii",$p_nombre_likes,$p_id_message);
            $nombre_dislikes_modifie = $nombre_dislikes;
            $nombre_likes_modifie = $nombre_likes+1;
            $p_nombre_likes = $nombre_likes_modifie;
            $p_id_message = $id_message;

            /**
             * exécuter la requête 
             */
            $stmt->execute();
            $resultat[]=array("nouveau_nombre_likes"=>$nombre_likes_modifie,"nouveau_nombre_dislikes"=>$nombre_dislikes_modifie);
            echo json_encode($resultat);
        }
    }
    /*
   if(!empty($_POST)){
       $id_message = intval($_POST['id_message']);
       $nombre_likes = intval($_POST['nombre_likes']);
       $nombre_dislikes = intval($_POST['nombre_dislikes']);
       $id_element = intval($_POST['id_element']);
       $dislikeDecrement = $_POST['dislikeIncrement'];
       $requete_modifier = "";
       $nombre_likes_modifie = 0;
       $nombre_dislikes_modifie = 0;
       $resultat = array();

       // préparer la requête 
       if($dislikeDecrement == true){
        $requete_modifier = "UPDATE message set nombre_likes=?, nombre_dislikes = ? WHERE id_message = ? ";
        $stmt = $connexionBDD->connexion->prepare($requete_modifier);
        $stmt->bind_param("iii",$p_nombre_likes,$p_nombre_dislikes,$p_id_message);
        $p_id_message = $id_message;
        $p_nombre_likes = $nombre_likes+1;
        $p_nombre_dislikes = $nombre_dislikes-1;
        $nombre_likes_modifie = $p_nombre_likes;
        $nombre_dislikes_modifie = $p_nombre_dislikes;
       }
       else if($dislikeDecrement == false){
        $requete_modifier = "UPDATE message set nombre_likes=? WHERE id_message = ? ";
        $stmt->bind_param("ii",$p_nombre_likes,$p_id_message);
        $p_id_message = $id_message;
        $p_nombre_likes = $nombre_likes+1;
        $nombre_likes_modifie = $p_nombre_likes;
        $nombre_dislikes_modifie = $nombre_dislikes;
        
       }
       $stmt->execute();
       $resultat[] = array('num_likes'=>$nombre_likes_modifie,"num_dislikes=>$nombre_dislikes_modifie", "id_message"=>$id_message);
       echo json_encode($resultat);
   }

                /*
