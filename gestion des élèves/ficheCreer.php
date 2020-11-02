<?php
    require_once 'connexionbd.php';
    require_once 'eleve.php';
    require_once 'function.php';

    /**
     * les variables
     */
   
    $erreurs = [];
    $messages = [];
    $appreciations = ["très Bien","bien","moyen","pas bien"];
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

         /**
             * si y a pas de erreurs de saisi on insérer les données à la base 
             */
            if(empty($erreurs)){

            /**
             * créer un nouveau élève dans la base de données 
             */    
              /**
                 * préparer la requête d'insertion et ses paramétres 
                 */
                $requete = "INSERT INTO eleve(nom,prenom,date_naissance,moyen,appreciation) VALUES (?,?,?,?,?);";
                $stmt = $GLOBALS['connexion']->prepare($requete);
                $stmt->bind_param("sssds",$p_nom,$p_prenom,$p_date_naissance,$p_moyen,$p_appreciation);
                $p_nom = $eleve->get_nom();
                $p_prenom = $eleve->get_prenom();
                $p_date_naissance = $eleve->getDateFormatSql();
                $p_moyen = $eleve->get_moyen();
                $p_appreciation = $eleve->get_appreciation();
                /**
                 * exécuter la requête 
                 */
                $stmt->execute();
                $id = $stmt->insert_id;
                $eleve->set_id($id);
                $stmt->close(); 

                if($id!=0){
                    $messages[] = "insertion réussite.....!";

                }else{
                    $erreurs = "insertion échouée ou erreur de connexion....!";
                }

                header("Location: ficheCreer.php");
                die;

            }
     }
           
?>

<!-- rendu -->
<html>
    <head></head>
    <body>
    <h1>Gestion des élèves</h1>
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
        <input type="submit" name="submit" value="Créer"/>


    </form>
    <a href="index.php">Retour</a>
   
    </body>
</html>