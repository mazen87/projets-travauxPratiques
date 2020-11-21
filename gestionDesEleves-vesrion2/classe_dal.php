<?php 
    require_once 'connexionbd.php';
    require_once 'classe.php';

    class Classe_dal {

        /**
         * fonction permet de récupérer toutes les classe depuis la base de données 
         */
        public function select_toutes_classe (){
            $dbconnect = Connexionbd::getInstance("mysql:host=localhost;dbname=gestion_eleves","root","");
            $classes = array();
            $requete_select_toutes_classes = "SELECT id,nom_classe FROM classe ";
            $stmt=$dbconnect->connexion->prepare($requete_select_toutes_classes);
            $stmt->execute();
            $classes= $stmt->fetchAll();
            for($i=0;$i<count($classes);$i++){
                $classes_objets[] = Classe::conctruc_classe_rempli($classes[$i]['id'],$classes[$i]['nom_classe']);
            }
            
            return $classes_objets;
            }
    }