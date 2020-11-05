<?php 
    class  Voiture  {
        
        public $couleur;
        public $model;
        public $objectCree;
        private static $object = NULL;

        function  __construct($model,$couleur){
            $this->couleur = $couleur;
            $this->model = $model;
            
        }

        public static function construit_singleton ($model,$couleur){
            if(isset(self::$object)){
                // objet déja existe 
                return self::$object;
            }else{
                // objet ne existe pas et on le crée 
                self::$object = new Voiture($model,$couleur);
                return self::$object;
            }
        }

        
    }


    
