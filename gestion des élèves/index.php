<?php
    require_once 'connexionbd.php';
    require_once 'eleve.php';
    require_once 'function.php';

    /**
     * récupérer tous les élèves dans la base 
     * préparer la requête 
     */
    $sum =0;
    $avg=0;
    $eleves = [];
    $requete_select_tous_eleve = "SELECT id,nom,prenom,date_naissance,moyen,appreciation FROM eleve";
    $stmt=$GLOBALS['connexion']->prepare($requete_select_tous_eleve);
    $stmt->execute();
    $stmt->bind_result($r_id,$r_nom,$r_prenom,$rdate_naissance,$r_moyen,$r_appreciation);
    while($stmt->fetch()){
        $eleves[] = Eleve::rempli_const($r_id,$r_nom,$r_prenom,$rdate_naissance,$r_moyen,$r_appreciation);
      
    }

 

    /**
     * calculer le nombre d'élèves et le moyen généreal pour tous les élèves 
     */
    if($eleves){
    $nombre =count($eleves);
    foreach($eleves as $eleve){
        $sum += $eleve->get_moyen();
    }
    if($sum != 0){
    $avg = $sum / $nombre;
    $avg = round($avg,3);
    }
    }
    





?>

<!-- rendu -->
 <html>
 <head></head>
 <body>
    <h1>Gestion des élèves</h1>
    <h3>Liste des élèves </h3>
    <?php 
        if(count($eleves)!=0){
    ?>
    <table> 
        <tr>
            <th>Nom</th><th>Prénom</th><th>Date de naissance</th><th>Moyen</th><th>Appréciation</th>
        </tr>
    <?php
        for($i=0;$i<count($eleves);$i++){
    ?>
        <tr>
            <td><?=$eleves[$i]->get_nom()?></td>
            <td><?=$eleves[$i]->get_prenom()?></td>
            <td><?=$eleves[$i]->get_date_naissance()->format("d/m/Y")?></td>
            <td><?php if($eleves[$i]->get_moyen()!=0){echo $eleves[$i]->get_moyen();} ?></td> 
            <td><?=$eleves[$i]->get_appreciation()?></td>
            <td><a href="ficheModifier.php?id_eleve=<?=$eleves[$i]->get_id()?>">Modifier</a></td>
        </tr>   
    <?php     
        }            
        }
    ?>
    </table>
    <div>
    <br>
    <label> Nombre d'élèves : </label><span><?php  if($nombre!=0){echo $nombre;} ?></span><br>
    <label> Moyen de classe : </label><span><?php  if($avg!=0){echo $avg;}  ?></span><br>
    </div>
    <br>
    <a href="ficheCreer.php">créer un élève</a>
 
 </body>
 </html>
