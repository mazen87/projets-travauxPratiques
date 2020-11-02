<?php
$sql_host = "localhost";
$sql_login = "root";
$sql_pwd = "";
$sql_db = "gestion_eleves";

//Connexion

$GLOBALS['connexion'] = new mysqli($sql_host, $sql_login, $sql_pwd, $sql_db);
$GLOBALS['connexion']->set_charset("UTF8");
