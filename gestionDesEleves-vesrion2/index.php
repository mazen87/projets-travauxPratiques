<?php
    require_once 'connexionbd.php';
    require_once 'eleve.php';
    require_once 'function.php';
    require_once 'eleve_dal.php';
    require_once 'classe_dal.php';
    require_once 'lessc.inc.php';
    /**
     * récupérer tous les élèves dans la base 
     * préparer la requête 
     */
    $classe_dal = new Classe_dal();
    $classes = $classe_dal->select_toutes_classe();
    /**
     * récupérer tous les éleves depuis la BDD
     */
    $id_classe = 0;
    $eleve_dal = new Eleve_dal();
    if(!empty($_POST['classe'])){
        if($_POST['classe']==0){
            $eleves = $eleve_dal->select_tous_eleves();
        }else{
            $id_classe = intval($_POST['classe']);
            $eleves = $eleve_dal->select_tous_eleves_classe($id_classe);
        }
    }else{
    
        $eleves = $eleve_dal->select_tous_eleves();
    }
    /**
     * calculer le nombre d'élèves et le moyen généreal pour tous les élèves 
     */
    if($eleves){
    $nombre =count($eleves);
    $sum = 0;
    foreach($eleves as $eleve){
        
        $sum += $eleve->get_moyen();
    }
    $avg =0;
    if($sum != 0){
    
    $avg = $sum / $nombre;
    $avg = round($avg,3);
     }
    }
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
                $("#filtrer").validate({
                   rules:{ 
                    classe:{
                        required:true
                    }
                   }
                })
         })
    </script>
 </head>
 <body>
     <header>
    <h1>Gestion des élèves</h1>
    <h2>Liste des élèves </h2>
    </header>
    <form method="POST" id="filtrer">
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
                        <option value="0"> Afficher tous </option>
            </select>
            <input type="submit" value="Filtrer"/>
    </form>
    <?php 
        if(count($eleves)!=0){
    ?>
    <table> 
        <tr>
            <th>Nom</th><th>Prénom</th><th>Date de naissance</th><th>Moyen</th><th>Appréciation</th><th>Classe</th>
        </tr>
    <?php
        for($i=0;$i<count($eleves);$i++){         
    ?>
        <tr>
            <td><?=$eleves[$i]->get_nom()?></td>
            <td><?=$eleves[$i]->get_prenom()?></td>
            <td><?=$eleves[$i]->get_date_naissance()->format("d/M/Y")?></td>
            <td><?php if($eleves[$i]->get_moyen()!=0){echo $eleves[$i]->get_moyen();} ?></td> 
            <td><?=$eleves[$i]->get_appreciation()?></td>
            <td><?php   for($j=0;$j<count($classes);$j++){
                if($eleves[$i]->get_id_classe()==$classes[$j]->get_id()){echo $classes[$j]->get_nom_classe(); }
            }?></td>
            <td><a href="ficheModifier.php?id_eleve=<?=$eleves[$i]->get_id()?>">Modifier</a></td>
        </tr>   
    <?php     
        }            
        }     
    ?>
    </table>
    <div id="info">
    <br>
    <label> Nombre d'élèves : </label><span><?php  if($nombre!=0){echo $nombre;} ?></span><br>
    <label> Moyen    : </label><span><?php  if($avg!=0){echo $avg;}  ?></span><br>
    </div>
    <br>
    <a href="ficheCreer.php">créer un élève</a>
 </body>
 </html>
