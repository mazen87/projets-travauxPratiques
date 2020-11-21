<?php
    require_once 'connexionbd.php';
    require_once 'eleve.php';
    require_once 'function.php';
    require_once 'eleve_dal.php';
    require_once 'classe_dal.php';
    /**
     * les variables
     */
    $erreurs = [];
    $messages = [];
    $appreciations = ["Tres bien","bien","moyen","pas bien"];
    if(isset($_POST['submit'])){
        $eleve = new Eleve();

        if(!empty($_POST['nom'])){
            $eleve->set_nom( assainir_text_post("nom")) ;

        }else{
           $erreurs[] = "le nom est vide.....!";
        }
        if(!empty($_POST['prenom'])){
            $eleve->set_prenom( assainir_text_post("prenom")) ;

        }else{
            $erreurs[] = "le prénom est vide.....!";
        }
        if(!empty($_POST['date_naissance'])){
            $eleve->set_date_naissance( assainir_text_post("date_naissance")) ;

        }else{
            $erreurs[] = "la date de naissance est vide.....!";
        }

        if(isset($_POST['moyen'])){
            $eleve->set_moyen( assainir_double_post("moyen")) ;

        }
        if(isset($_POST['appreciation'])){
            $eleve->set_appreciation( assainir_text_post("appreciation")) ;

        }
        if(!empty($_POST['classe'])){
            $eleve->set_id_classe( assainir_int_post("classe")) ;

        }else{
            $erreurs[] = "il faut choisir une classe pour l'éleève à créer...";
        }
         /**
             * si y a pas de erreurs de saisi on insérer les données à la base 
             */
            if(empty($erreurs)){

            /**
             * créer un nouveau élève dans la base de données 
             */    
                $eleve_dal = new Eleve_dal();
                $insertion = $eleve_dal->insert_eleve($eleve);
                if($insertion){
                    $messages[] = "insertion réussite.....!";
                }else{
                    $erreurs = "insertion échouée ou erreur de connexion....!";
                }
                header("Location: ficheCreer.php");
                die;
            }
     }
     /**
      * récupérer toutes les classes depuis la BDD
      */
      $classe_dal = new Classe_dal();
      $classes = $classe_dal->select_toutes_classe();        
?>
<!-- rendu -->
<html>
    <head>
        <link rel="stylesheet/less" type="text/css" href="index.less" />
        <script src="less.js"></script>
        <script src="jquery-3.5.1.min.js"></script>
        <script src="jquery.validate.js"></script>
        <script src="messages_fr.js"></script>
        <script>
            $(function(){
                $("#creation").validate({
                        rules: {
                            nom: {
                                minlength: 2,
                                required : true
                            },
                            prenom:{
                                required : true,
                                minlength: 2,
                            },
                            date_naissance : {
                                required:true
                            },
                            moyen:{
                                number: true
                            },
                            appreciation:{
                            },
                            classe:{
                                required:true
                            },
                          
                        }, 
                });
            });
        </script>
    </head>
    <body>
    <header>    
    <h1>Gestion des élèves</h1>
    <h2>Créer un élève</h2>
    </header>
    <ul>
    <?php 
        for($i=0;$i<count($erreurs);$i++){
     ?>
        <li><?=$erreurs[$i]?></li>
    <?php
        }
    ?>
    </ul>

    <ul>
    <?php 
        for($i=0;$i<count($messages);$i++){
     ?>
        <li><?=$messages[$i]?></li>
    <?php
        }
    ?>
    </ul>

    <form method="POST" id="creation">
        <input type="text" name="nom" placeholder="nom d'élève...."    />
        <input type="text" name="prenom" placeholder="prénom d'élève...." />
        <input type="date"  name="date_naissance"/>
        <input type="number" step="any" name="moyen"  placeholder="moyen ....." />
        <select name="appreciation" > 
            <option value="" selected>choisir une appréciation </option>
            <?php 
                for($i=0;$i<count($appreciations);$i++){
            ?>
                    <option value="<?=$appreciations[$i]?>"><?=$appreciations[$i]?> </option>
            <?php        
                }
            ?> 
        </select>
        <select name="classe" > 
            <option value="" selected>choisir une classe </option>
            <?php 
                for($i=0;$i<count($classes);$i++){
            ?>
                    <option value="<?=$classes[$i]->get_id()?>"><?=$classes[$i]->get_nom_classe()?> </option>
            <?php        
                }
            ?> 
        </select>
        <input type="submit" name="submit" value="Créer"/>
    </form>
    <a href="index.php">Retour</a>
    </body>
</html>