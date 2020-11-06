<?php
class Connexionbdd {

    public $host;
    public $login;
    public $pw;
    public $bdd;
    public $connexion;
    private static $objet = NULL;
    

    function __construct($host,$login,$pw,$bdd)
    {
        $this->host = $host;
        $this->login = $login;
        $this->pw = $pw;
        $this->bdd = $bdd;
      

        $this->connexion = new mysqli($host,$login,$pw,$bdd);
        $this->connexion->set_charset("UTF8");
    }

    public static function Construct_objetBDD ($host,$login,$pw,$bdd){
        if(isset(self::$objet)){
            return self::$objet;
        }else{
            self::$objet = new Connexionbdd ($host,$login,$pw,$bdd);
            return self::$objet;
        }
    }
}

/*
$sql_host = "localhost";
$sql_login = "root";
$sql_pwd = "";
$sql_db = "fruits";

//Connexion

$GLOBALS['connexion'] = new mysqli($sql_host, $sql_login, $sql_pwd, $sql_db);
$GLOBALS['connexion']->set_charset("UTF8");

*/
