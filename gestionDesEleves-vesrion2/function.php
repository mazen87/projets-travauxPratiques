<?php 
    require_once 'connexionbd.php';
    require_once 'eleve.php';

    /**
     * fonction prend en paramétre le nom de clé dans la variable post et renvoie sa valeur 
     */
     function assainir_text_post($cle){
         if(isset($_POST[$cle])){
            return htmlspecialchars(trim(strip_tags($_POST[$cle])));
         }else {
             return "";
         }
         
    }
/**
     * fonction prend en paramétre le nom de clé dans la variable post et renvoie sa valeur qui est un numéro decimal 
     */
    function assainir_double_post($cle){
        if(isset($_POST[$cle])){
           return doubleval($_POST[$cle]);
        }else {
            return 0;
        }
        
   }
   function assainir_int_post($cle){
    if(isset($_POST[$cle])){
       return intval($_POST[$cle]);
    }else {
        return 0;
    }
    
}
?>