<?php
    session_start();
    require_once 'connexionbdd.php';
    $erreurs = [];
    ?>
    
<html>
    <head>

    </head>
    <body>
        <h1> bienvenu sur le site Forum de Discussion</h1>
        <?php
        //récupérer les catégories (forums):
            $selectForums = "select c.nom, max(m.titre) as titre ,MAX(m.date) as date  from categorie c LEFT join message m on c.id = m.id_categorie group by c.nom "; 
            $resultat = mysqli_query($link, $selectForums);
            if($resultat){
                echo "<table><th>nom du forum</<th><th>dernier sujet</th><th>date de dernier sujet</th>";
              
                while($ligne_resultat = mysqli_fetch_assoc($resultat)){
                    echo "<tr>";
                    echo "<td>".$ligne_resultat['nom']."</td><td>".$ligne_resultat['titre']."</td><td>".$ligne_resultat['date']."</td>";
                }
                echo "</table>";
            }else{
                $erreurs[] = "erreur de connexion à la base de données...!";
            }
    
        //redirection vers s'inscrire
        if(isset($_POST['inscrire'])){
            header("location: http://forumdiscussion/inscrire.php");
            exit();
        }
    
        //redirection vers se connecter 
        if(isset($_POST['connecter'])){
             header("location: http://forumdiscussion/connecter.php");
            exit();
        }
    ?>
    
        <?php
            if(count($erreurs)){
                echo "<ul>";
                for($i = 0;$i<count($erreurs);$i++){
                    echo "<li>".$erreurs[$i]."</li>";
                
                }
                echo "</ul>";
            }
            
            ?>
  <br><br>
<div>
    <form method="POST">
        <input type="submit" value="s'inscrire" name="inscrire"/><br><br>
    </form>
</div>
<div>
    <form method="POST">
    <input type="submit" value="se connecter" name="connecter"/><br><br>
    </form>
</div>

      
</body>
</html>