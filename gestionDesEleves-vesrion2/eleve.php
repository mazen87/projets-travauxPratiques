<?php
     class Eleve {
         /**
          * les variable : 
          */
        private $id;
        private $nom;
        private $prenom;
        private $date_naissance;
        private $moyen;
        private $appreciation;
        private $id_classe;

        /**
         * constructeur de la classe 
         */
        function __construct()
        {
           $this->id = 0;
           $this->nom = "";
           $this->prenom = "";
           $this->date_naissance = new DateTime();
           $this->moyen = 0;
           $this->appreciation = "";
           $this->id_classe = 0;
            
        }
        /**
         * getters : desfonctions permettant de récupérer les valeurs de variables de classe
         */
        
        public function get_id(){
           return $this->id;
        }
        public function get_nom(){
         return $this->nom;
      }
      public function get_prenom(){
         return $this->prenom;
      }
      public function get_date_naissance(){
         return $this->date_naissance;
      }
      public function get_moyen(){
         return $this->moyen;
      }
      public function get_appreciation(){
         return $this->appreciation;
      }
     
      public function get_id_classe(){
         return $this->id_classe;
      }

      /**
       * setters : des fonctions permettant d'affecter des valeurs aux variables de classe 
       */

       public function set_id($id){
          $this->id = $id;
       }
       public function set_nom($nom){
         $this->nom = $nom;
      }
      public function set_prenom($prenom){
         $this->prenom = $prenom;
      }
      public function set_date_naissance($date_naissance){
         $this->date_naissance = new DateTime($date_naissance);
      }
      public function set_moyen($moyen){
         $this->moyen = floatval($moyen);
      }
      public function set_appreciation($appreciation){
         $this->appreciation = $appreciation;
      }
      public function set_id_classe($id_classe){
         $this->id_classe = $id_classe;
      }

      /**
       * function permettent de créer un objet de la classe et charger ses variables par les valeurs passées en paramétre et renvoie cet objet 
       */
        public static function rempli_const($id,$nom,$prenom,$date_naissance,$moyen,$appreciation,$id_classe){
           $eleve = new Eleve();
           $eleve->set_id($id);
           $eleve->set_nom($nom);
           $eleve->set_prenom($prenom);
           $eleve->set_date_naissance($date_naissance);
           $eleve->set_moyen($moyen);
           $eleve->set_appreciation($appreciation);
           $eleve->set_id_classe($id_classe);

           return $eleve;
        }

        /**
         * fonction permet de convertir la date en format sql 
         */
        public function getDateFormatSql() {
         return $this->date_naissance->format("Y-m-d H:i:s");
      }

    

 }

