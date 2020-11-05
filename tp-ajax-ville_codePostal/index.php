<?php 
    require_once 'connexionbdd.php';

    /*
   $nombre = 0;
    // traiter la post 
    if(!empty($_POST)){
            $nombre = intval($_POST['nombre']);
                echo $nombre;
                if($nombre % 2 == 0){
                   // $resultat= array('res'=>"paire");
                   echo  json_encode("paire");
                }
                else{
                    //$resultat= array('res'=>"impaire");
                   echo  json_encode("impaire");
                }
                }
            
        

        //envoyer le resultat 

        */

        /*
        // traiter le bar de recherche
        //déclarer les variables 
        
        if(!empty($_POST)){
         
            $saisi = "";
            $fruits = array();               
            $saisi = trim(strip_tags($_POST['recherche']));

            //on prépare la requête 
            $requete = "SELECT nom from fruit where nom LIKE ? ";
            $stmt = $GLOBALS['connexion']->prepare($requete);
            $stmt->bind_param("s",$p_nom);
            $p_nom = "%".$saisi."%";
            // éxecuter la requête 
            $stmt->execute();
            $stmt->bind_result($r_nom); 
            //$result = $stmt->get_result();
            while($stmt->fetch()){
                $fruits[] = array("nom"=>$r_nom);
            }
           
           echo json_encode($fruits);
        }
        */
        //traiter les bars de recherches pour la ville & code postal 
        if(!empty($_POST)){
            $recherche_v = "";
            $recherche_cp ="";
            $villes_cp = array();
            
            if(!empty($_POST['recherche_v'])){
            $recherche_v = trim(strip_tags($_POST['recherche_v']));
            }  
            if(!empty($_POST['recherche_cp'])){
                $recherche_cp = trim(strip_tags($_POST['recherche_cp']));
                }
            
            // on prépare la requête 
            $requete_ville_cp = "SELECT nom,code_postal from ville WHERE nom LIKE ? or code_postal LIKE ? ORDER BY population DESC";
            $stmt = $GLOBALS['connexion']->prepare($requete_ville_cp);
            $stmt->bind_param("ss",$p_nom_ville,$p_code_postal);
            if(!empty($recherche_v) && empty($recherche_cp)){
                $p_nom_ville = "%".$recherche_v."%";
                $p_code_postal = $recherche_cp;
            }
            if(!empty($recherche_cp) && empty($recherche_v)){
                $p_nom_ville = $recherche_v;
                $p_code_postal = "%".$recherche_cp."%";
            }
            //exécuter la requête 
            $stmt->execute();
            $stmt->bind_result($r_nom_ville,$r_code_postal);
            while($stmt->fetch()){
                $villes_cp[] = array("nom"=>$r_nom_ville,"code_postal"=>$r_code_postal);
            }
            echo json_encode($villes_cp);
           
        }

?>