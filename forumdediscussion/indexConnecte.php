<?php
    session_start();
    require_once 'connexionbdd.php';
    $erreurs = [];
    ?>
    
<html>
    <head>

    </head>
    <body>
        <h1> bienvenu <?php echo $_SESSION['pseudo']?> sur le site Forum de Discussion</h1>
        <?php
        //récupérer les catégories (forums):
            $selectForums = "select c.nom, c.id, max(m.titre) as titre ,MAX(m.date) as date  from categorie c LEFT join message m on c.id = m.id_categorie group by c.nom "; 
            $resultat = mysqli_query($link, $selectForums);
            if($resultat){
                echo "<table><th>nom du forum</<th><th>dernier sujet</th><th>date de dernier sujet</th>";
              
                while($ligne_resultat = mysqli_fetch_assoc($resultat)){
                    echo "<tr>";
                    echo "<td><a href=\"/forum.php?id=".$ligne_resultat['id']."&forum=".$ligne_resultat['nom']."\">".$ligne_resultat['nom']."</a></td><td>".$ligne_resultat['titre']."</td><td>".$ligne_resultat['date']."</td></tr>";
                }
                echo "</table>";
            }else{
                $erreurs[] = "erreur de connexion à la base de données...!";
            }
    
            
    //redirection vers la page de modification 
    if(isset($_POST['Modifier'])){
        header("Location: http://forumdiscussion/modifier.php");
        exit();

    }
     //se déconnecter 
        if(isset($_POST['deconn'])){
            session_destroy();
            header("Location: http://localhost/forumdiscussion/index.php");
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


  </form>
<form method="POST">
<button type="submit" name="deconn">se déconnecter</button>
</form>


<form method="POST">
<button type="submit" name="Modifier">Modifier votre profil </button>
</form>

</body>
</html>