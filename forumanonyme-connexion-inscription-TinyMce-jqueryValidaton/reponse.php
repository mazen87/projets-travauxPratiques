<?php
 class Reponse {
     /**
      * déclaration des variables 
      */
      private $id;
      private $contenu_reponse;
      private $date_reponse;
      private $id_message;
      private $id_utilisateur;
      public $pseudo_createur_reponse;

      /**
       * constructeur
       */
      function __construct()
      {
          $this->id = 0;
          $this->contenu_reponse = "";
          $this->date_reponse = new DateTime();
          $this->id_message = 0;
          $this->id_utilisateur=0;
          $this->pseudo_createur_reponse ="";
      }

      /**
       * les getters et les setters
       * les getters
       */
      public function get_id (){
          return $this->id;
      }
      public function get_contenu_reponse (){
        return $this->contenu_reponse;
    }
    public function get_date_reponse (){
        return $this->date_reponse;
    }
    public function get_id_message (){
        return $this->id_message;
    }
    public function get_id_utilisateur(){
        return $this->id_utilisateur;
    }

    /**
     * les setters
     */
    public function set_id ($id){
        $this->id = $id;
    }
    public function set_contenu_reponse ($contenu_reponse){
        $this->contenu_reponse = $contenu_reponse;
    }
    public function set_date_reponse ($date_reponse){
        $this->date_reponse = new DateTime($date_reponse);
    }
    public function set_id_message ($id_message){
        $this->id_message = $id_message;
    }
    public function set_id_utilisateur ($id_utilisateur){
        $this->id_utilisateur = $id_utilisateur;
    }
    /**
     * fonction permettre de créer un objet reponse et le remplire par des valeurs passées en paramétre et renvoie cet objet 
     */
    public static function construct_rempli($id_reponse,$contenu_reponse,$date_reponse,$id_message,$id_utilisateur,$pseudo_createur_reponse){
        $reponse = new Reponse();
        $reponse->set_id($id_reponse);
        $reponse->set_contenu_reponse($contenu_reponse);
        $reponse->set_date_reponse($date_reponse);
        $reponse->set_id_message($id_message);
        $reponse->set_id_utilisateur($id_utilisateur);
        $reponse->pseudo_createur_reponse = $pseudo_createur_reponse;

        return $reponse;
    }
    /**
    * fonction permet de convertir la date en format sql 
     */
        public function getDateFormatSql() {
            return $this->date_reponse->format("Y-m-d");
         }
 }