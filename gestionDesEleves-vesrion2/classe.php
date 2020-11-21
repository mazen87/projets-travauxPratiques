<?php
    class Classe {

        private $id;
        private $nom_classe;

        function __construct()
        {
            $this->id = 0;
            $this->nom_classe = "";
        }

        /**
         * les getters et setters 
         */
        public function get_id(){
            return $this->id;
        }
        public function get_nom_classe(){
            return $this->nom_classe;
        }

        public function set_id($id){
            $this->id = $id;
        }
        public function set_nom_classe($nom_classe){
            $this->nom_classe = $nom_classe;
        }

        /**
         * fonction qui prend la role d'un constructeur qui 
         * crée un objet, et le charge par les données passées en paramétre 
         * renvoie cet objet 
         */
        public static function conctruc_classe_rempli ($id,$nom_classe){
            $classe = new Classe();
            $classe->set_id($id);
            $classe->set_nom_classe($nom_classe);

            return $classe;
        }
    }