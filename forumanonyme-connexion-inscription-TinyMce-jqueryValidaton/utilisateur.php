<?php
    class Utilisateur {
        public $id;
        public $email;
        public $pseudo;
        public $motDePasse;

        function __construct()
        {
            $this->id = 0;
            $this->email = "";
            $this->pseudo = "";
            $this->motDePasse = "";
        }

        public static function const_rempli_utilisateur ($id,$email,$pseudo,$motDePasse){
                $utilisateur = new Utilisateur();
                $utilisateur->id = $id;
                $utilisateur->email = $email;
                $utilisateur->pseudo = $pseudo;
                $utilisateur->motDePasse = $motDePasse;

                return $utilisateur;
        }
    }