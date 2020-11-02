<?php
 require_once 'connexionbd.php';
 require_once 'eleve.php';
 require_once 'function.php';
 $erreurs = [];
 $messages = [];
 $appreciations = ["très bien","bien","moyen","pas bien"];
 if(!empty($_GET['id_eleve'])){
     $id_eleve = intval($_GET['id_eleve']);
 }


 $eleve = new Eleve();

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
      /**
 * si y a pas de erreurs de saisi on insérer les données à la base 
*/
     if(empty($erreurs)){
         /**
             * modification les données d'un élève existe dans la base de données 
             */

            /**
            * préparer la requête de modification 
            */
            $requete_modifier ="UPDATE eleve SET nom =? , prenom =?, date_naissance =?, moyen =?,appreciation =? WHERE id =?";
            $stmt = $GLOBALS['connexion']->prepare($requete_modifier);
            $stmt->bind_param("sssdsi",$p_nom,$p_prenom,$p_date_naissance,$p_moyen,$p_appreciation,$p_id);
          

            $p_nom = $eleve->get_nom();
            $p_prenom = $eleve->get_prenom();
            $p_date_naissance = $eleve->getDateFormatSql();
            $p_moyen = $eleve->get_moyen();
            $p_appreciation = $eleve->get_appreciation();
            $p_id = $id_eleve;
            $retour=$stmt->execute();
            if($retour){
                $messages[]= "Modification réussite...!"; 
            }else{
                $erreurs[] = "modification échouée ou erreur de connexion ....!";
            }
            $stmt->close();

         


     }
     
     
    header("Location: ficheModifier.php?id_eleve=$id_eleve");

    }
    

            /**
  * récupérer les données correspondants à l'id 
  */
  /**
   * préparer la requête 
   */
  $requete_select_by_id_eleve = "SELECT nom,prenom,date_naissance,moyen,appreciation FROM eleve WHERE id=?";
  $stmt=$GLOBALS['connexion']->prepare($requete_select_by_id_eleve);
  $stmt->bind_param("i",$id_eleve);
  $stmt->execute();
  $stmt->bind_result($r_nom,$r_prenom,$r_date_naissance,$r_moyen,$r_appreciation);
  $stmt->fetch();

  $eleve_recupere = new Eleve();
  $eleve_recupere->set_id($id_eleve);
  $eleve_recupere->set_nom($r_nom);
  $eleve_recupere->set_prenom($r_prenom);
  $eleve_recupere->set_date_naissance($r_date_naissance);
  $eleve_recupere->set_moyen($r_moyen);
  $eleve_recupere->set_appreciation($r_appreciation);    
   
    ?>
    <html>
    <head></head>
    <body>
    <h1>Gestion des élèves</h1>
    <h3>Modifier un élèves</h3>
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

    <form method="POST">
        <input type="text" name="nom" placeholder="nom d'élève...."  value="<?=$eleve_recupere->get_nom()?>"   />
        <input type="text" name="prenom" placeholder="prénom d'élève...." value="<?=$eleve_recupere->get_prenom()?>" />
        <input type="date" name="date_naissance" value="<?=$eleve_recupere->getDateFormatSql()?>" />
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
        <input type="submit" name="submit" value="Modifier"/>


    </form>
    <a href="index.php">Retour</a>
   
    </body>
</html>





 