<?php
    class Message {

        /**
         * déclaration des variables 
         */
        private $id;
        private $contenu;
        private $date_message;
        private $id_utilisateur;
        private $nombre_likes;
        private $nombre_dislikes;
        private $reponses;
        private $nombre_reponses;
        public $pseudo;

        /**
         * constructeur 
         */
        function __construct()
        {
            $this->id = 0;
            $this->contenu = "";
            $this->date_message = new DateTime();
            $this->id_utilisateur = 0;
            $this->nombre_likes = 0;
            $this->nombre_dislikes = 0;
            $this->reponses = array();
            $this->nombre_reponses = 0;
            $this->pseudo = "";
            
        }

        /**
         * les getters and setters 
         * les getters 
         */
        public function get_id (){
            return $this->id;
        }
        
        public function get_contenu (){
            return $this->contenu;
        }
        
        public function get_date_message (){
            return $this->date_message;
        }
        
        public function get_id_utilisateur (){
            return $this->id_utilisateur;
        }
        
        public function get_nombre_likes (){
            return $this->nombre_likes;
        }
        
        public function get_nombre_dislikes (){
            return $this->nombre_dislikes;
        }
        
        public function get_reponses (){
            return $this->reponses;
        }
        public function get_nombre_reponses (){
            return $this->nombre_reponses;
        }

        /**
         * les setters 
         */
        public function set_id ($id){
            $this->id = $id;
        }
        public function set_contenu ($contenu){
            $this->contenu = $contenu;
        }
        public function set_date_message ($date_message){
            $this->date_message = new DateTime($date_message);
        }
        public function set_id_utilisateur ($id_utilisateur){
            $this->id_utilisateur = $id_utilisateur;
        }
        public function set_nombre_likes ($nombre_likes){
            $this->nombre_likes = $nombre_likes;
        }
        public function set_nombre_dislikes ($nombre_dislikes){
            $this->nombre_dislikes = $nombre_dislikes;
        }
        public function set_reponses ($reponses){
            $this->reponses = $reponses;
        }
        public function set_nombre_reponses ($nombre_reponses){
            $this->nombre_reponses = $nombre_reponses;
        }

        /**
         * fonction permettre de créer un objet message et le remplir par des valeur passer en paramétre et renvoie cet objet 
         */
        public static function construct_rempli_avec_nombre_reponses ($id,$id_utilisateur,$contenu,$date_creation,$nombre_reponses,$pseudo){
                $message = new Message();
                $message->set_id($id) ;
                $message->set_id_utilisateur($id_utilisateur);
                $message->set_contenu($contenu);
                //$message->set_nombre_likes($nombre_likes);
                //$message->set_nombre_dislikes($nombre_dislikes);
                $message->set_date_message($date_creation);
                $message->set_nombre_reponses($nombre_reponses);
                $message->pseudo = $pseudo;
                
                return $message;
        }
        public static function construct_rempli_avec_nombre_reponses_avecnombreLikesDislikes ($id,$id_utilisateur,$contenu,$date_creation,$nombre_reponses,$nombre_likes,$nombre_dislikes,$pseudo){
            $message = new Message();
            $message->set_id($id) ;
            $message->set_id_utilisateur($id_utilisateur);
            $message->set_contenu($contenu);
            $message->set_nombre_likes($nombre_likes);
            $message->set_nombre_dislikes($nombre_dislikes);
            $message->set_date_message($date_creation);
            $message->set_nombre_reponses($nombre_reponses);
            $message->pseudo = $pseudo;
            
            return $message;
    }


        /**
         * fonction permet de convertir la date en format sql 
         */
        public function getDateFormatSql() {
            return $this->date_message->format("Y-m-d");
         }
    }