<?php
require_once 'connexionbd.php';
require_once 'eleve.php';
    class Eleve_dal {

        /**
         * fonction permet de créer un nouvel eleve à la BDD 
         */
        public function insert_eleve ($eleve){
            //$eleve = new Eleve();
            //$id_cree = 0;
            $dbconnect = Connexionbd::getInstance("mysql:host=localhost;dbname=gestion_eleves;charset=utf8","root","");
            $requete_insertion_eleve = "INSERT INTO eleve (nom,prenom,date_naissance,moyen,appreciation,id_classe)VALUES (:nom,:prenom,:date_naissance,:moyen,:appreciation,:id_classe)";
            $stmt = $dbconnect->connexion->prepare($requete_insertion_eleve);
            $nom = $eleve->get_nom();
            $stmt->bindParam(':nom',$nom,PDO::PARAM_STR);
            $prenom =$eleve->get_prenom();
            $stmt->bindParam(':prenom',$prenom,PDO::PARAM_STR);
            $date_naissance = $eleve->getDateFormatSql();
            $stmt->bindParam(':date_naissance',$date_naissance,PDO::PARAM_STR);
            $moyen = $eleve->get_moyen();
            $stmt->bindParam(':moyen',$moyen,PDO::PARAM_INT);
            $appreciation =$eleve->get_appreciation();
            $stmt->bindParam(':appreciation',$appreciation,PDO::PARAM_STR);
            $id_class = $eleve->get_id_classe();
            $stmt->bindParam(':id_classe',$id_class,PDO::PARAM_INT);
            
            
            //$stmt->execute(array(':nom'=>$eleve->get_nom(),':prenom'=>$eleve->get_prenom(),':date_naissance'=>strtotime($eleve->getDateFormatSql()),':moyen'=>$eleve->get_moyen(),':appreciation'=>$eleve->get_appreciation(),':id_classe'=>1));
            

            return $stmt->execute();
        }


        /**
         * fonction permet de récupérer tous les éleves depuis la BDD 
         */
        public function select_tous_eleves (){
            $eleves = array();
            $dbconnect = Connexionbd::getInstance("mysql:host=localhost;dbname=gestion_eleves;charset=utf8","root","");
            $requete_select_tous_eleves = "SELECT id,nom,prenom,date_naissance,moyen,appreciation,id_classe FROM eleve";
            $stmt = $dbconnect->connexion->prepare($requete_select_tous_eleves);
            $stmt->execute();
            $eleves= $stmt->fetchAll(PDO::FETCH_ASSOC);
            for($i=0;$i<count($eleves);$i++){
                $eleves_objets[] = Eleve::rempli_const($eleves[$i]['id'],$eleves[$i]['nom'],$eleves[$i]['prenom'],$eleves[$i]['date_naissance'],$eleves[$i]['moyen'],$eleves[$i]['appreciation'],$eleves[$i]['id_classe']);
            }
                 return $eleves_objets;
        }

        /**
         * fonction permet de récupérer un objet eleve depuis la BDD par son ID 
         */
        public function select_eleve_id($id_eleve){
            $eleve = new Eleve();
            $dbconnect = Connexionbd::getInstance("mysql:host=localhost;dbname=gestion_eleves","root","");
            $requete_select__eleve_id = "SELECT id,nom,prenom,date_naissance,moyen,appreciation,id_classe FROM eleve WHERE id=:id";
            $stmt = $dbconnect->connexion->prepare($requete_select__eleve_id);
            $stmt->execute(array(':id'=>$id_eleve));
            $stmt->setFetchMode(PDO::FETCH_INTO,$eleve);
            $eleve=$stmt->fetch(PDO::FETCH_ASSOC);
            $eleve_objet = Eleve::rempli_const($eleve['id'],$eleve['nom'],$eleve['prenom'],$eleve['date_naissance'],$eleve['moyen'],$eleve['appreciation'],$eleve['id_classe']);

            return $eleve_objet;
        }

        /**
         * fonction permet de récupérer tous les élèves de même classes
         */

        public function select_tous_eleves_classe ($id_classe){
            $eleves = array();
            $dbconnect = Connexionbd::getInstance("mysql:host=localhost;dbname=gestion_eleves;charset=utf8","root","");
            $requete_select_tous_eleves = "SELECT id,nom,prenom,date_naissance,moyen,appreciation,id_classe FROM eleve WHERE id_classe=:id_classe";
            $stmt = $dbconnect->connexion->prepare($requete_select_tous_eleves);
            $stmt->execute(array(':id_classe'=>$id_classe));
            $eleves= $stmt->fetchAll(PDO::FETCH_ASSOC);
            for($i=0;$i<count($eleves);$i++){
                $eleves_objets[] = Eleve::rempli_const($eleves[$i]['id'],$eleves[$i]['nom'],$eleves[$i]['prenom'],$eleves[$i]['date_naissance'],$eleves[$i]['moyen'],$eleves[$i]['appreciation'],$eleves[$i]['id_classe']);
            }
                 return $eleves_objets;
        }

        /**
         * fonction permet de modifier un objet d'eleve dans la BDD
         */
        public function update_eleve ($eleve){
            $dbconnect = Connexionbd::getInstance("mysql:host=localhost;dbname=gestion_eleves;charset=utf8","root","");
            $requete_update_eleve = "UPDATE eleve SET nom =:nom ,prenom=:prenom ,date_naissance=:date_naissance,moyen=:moyen,appreciation=:appreciation,id_classe=:id_classe WHERE id=:id";
            $stmt = $dbconnect->connexion->prepare($requete_update_eleve);
            $id = $eleve->get_id();
            $stmt->bindParam(':id',$id,PDO::PARAM_INT);
            $nom = $eleve->get_nom();
            $stmt->bindParam(':nom',$nom,PDO::PARAM_STR);
            $prenom =$eleve->get_prenom();
            $stmt->bindParam(':prenom',$prenom,PDO::PARAM_STR);
            $date_naissance = $eleve->getDateFormatSql();
            $stmt->bindParam(':date_naissance',$date_naissance,PDO::PARAM_STR);
            $moyen = $eleve->get_moyen();
            $stmt->bindParam(':moyen',$moyen,PDO::PARAM_INT);
            $appreciation =$eleve->get_appreciation();
            $stmt->bindParam(':appreciation',$appreciation,PDO::PARAM_STR);
            $id_class = $eleve->get_id_classe();
            $stmt->bindParam(':id_classe',$id_class,PDO::PARAM_INT);

            return $stmt->execute();
        }


    }