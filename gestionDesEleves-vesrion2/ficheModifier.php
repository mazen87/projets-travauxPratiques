<?php
 require_once 'connexionbd.php';
 require_once 'eleve.php';
 require_once 'function.php';
 require_once 'eleve_dal.php';
 require_once 'classe_dal.php';
 require_once 'classe.php';
 $erreurs = [];
 $messages = [];
 $appreciations = ["Tres bien","bien","moyen","pas bien"];
 $eleve_dal = new Eleve_dal();

 if(!empty($_GET['id_eleve'])){
     $id_eleve = intval($_GET['id_eleve']);
 }
 $eleve = new Eleve();
 $eleve->set_id($id_eleve);

  if(isset($_POST['submit'])){

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
             * modification les données d'un élève existe dans la base de données 
             */
            $update = $eleve_dal->update_eleve($eleve);
            if($update){
                $messages[] = "mise à jour réussite.....!";
            }else{
                $erreurs = "mise à jour échouée ou erreur de connexion....!";
            }
     }
             header("Location: ficheModifier.php?id_eleve=$id_eleve");
    }
    /**
  * récupérer les données correspondants à l'id 
  */
   $eleve_recupere = new Eleve();
   $eleve_recupere = $eleve_dal->select_eleve_id($eleve->get_id());  
    /**
      * récupérer toutes les classes depuis la BDD
      */
      $classe_dal = new Classe_dal();
      $classes = $classe_dal->select_toutes_classe();
   ?>
    <html>
    <head>
        <link rel="stylesheet/less" type="text/css" href="index.less" />
        <script src="less.js"></script>
        <script src="jquery-3.5.1.min.js"></script>
        <script src="jquery.validate.js"></script>
        <script src="messages_fr.js"></script>
        <script>
            $(function(){
                $("#modification").validate({
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
    <h2>Modifier un élève</h2>
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
    <form method="POST" id="modification">
        <input type="text" name="nom" placeholder="nom d'élève...."  value="<?=$eleve_recupere->get_nom()?>"   />
        <input type="text" name="prenom" placeholder="prénom d'élève...." value="<?=$eleve_recupere->get_prenom()?>" />
        <input type="date" name="date_naissance" value="<?php echo $eleve_recupere->get_date_naissance()->format("Y-m-d")?>"/>
        <input type="number" name="moyen" step="any"  placeholder="moyen ....." value="<?php  if($eleve_recupere->get_moyen()!=0){echo $eleve_recupere->get_moyen();}?>"/>
        <select name="appreciation" > 
            <option value="" selected>choisir une appréciation </option>
            <?php 
                for($i=0;$i<count($appreciations);$i++){
                    if($appreciations[$i]==$eleve_recupere->get_appreciation()){
            ?>
                    <option value="<?=$appreciations[$i]?>" selected><?=$appreciations[$i]?> </option>
            <?php        
                }else{
            ?>
                   <option value="<?=$appreciations[$i]?>" ><?=$appreciations[$i]?> </option> 
            <?php       
                }
            }
            ?> 
        </select>
        </select>
        <select name="classe" > 
            <option value="" selected>choisir une classe </option>
            <?php 
                for($i=0;$i<count($classes);$i++){
            ?>
            <?php
                if($classes[$i]->get_id()==$eleve_recupere->get_id_classe()){
            ?>        
                    <option value="<?=$classes[$i]->get_id()?>" selected><?=$classes[$i]->get_nom_classe()?> </option>
                    <?php
                }
                else{
            ?>
                    <option value="<?=$classes[$i]->get_id()?>"><?=$classes[$i]->get_nom_classe()?> </option>
            <?php        
                }
            ?>
            <?php        
                }
            ?> 
        </select>
        <input type="submit" name="submit" value="Modifier"/>
    </form>
    <a href="index.php">Retour</a>
    </body>
</html>





 