<?php

$sql_host = "localhost";
$sql_login = "root";
$sql_pwd = "";
$sql_db = "gestion_eleves";

//Connexion

$GLOBALS['connexion'] = new mysqli($sql_host, $sql_login, $sql_pwd, $sql_db);
$GLOBALS['connexion']->set_charset("UTF8");

class Connexionbd 
{
    public $dsn_bdd;
    public $motDePasse;
    public $user;
    public $connexion;
    private static $object = null;

     function __construct($dsn_bdd,$user,$motDePasse) {
        $this->cdn_bdd = $dsn_bdd;
        $this->motDePasse = $motDePasse;
        $this->user = $user;
        $this->connexion = new PDO($dsn_bdd,$user,$motDePasse);
        
        $this->connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
     
    }

 

    public static function getInstance($dsn_bdd,$user,$motDePasse) {
        if (!(self::$object instanceof self)) {
            self::$object = new Connexionbd($dsn_bdd,$user,$motDePasse);
            return self::$object;
        }else{
            return self::$object;
        }
        
    }

}