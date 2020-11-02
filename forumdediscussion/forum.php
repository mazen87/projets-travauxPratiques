<?php
session_start();
require_once 'connexionbdd.php';
    $erreurs = [];
    $id_categorie = 0;
    $idClient = 0;
    $text ="";
    $titre ="";
    ?>
    

<html>
    <head>

    </head>
    <body>
    <h1> bienvenu <?php echo $_SESSION['pseudo']?> sur le site Forum de Discussion</h1>

        <?php
        //ajouter nouveau sujet 
        if(isset($_POST['nouveauSujet'])){
            if(isset($_POST['titre'])&& empty($_POST['titre'])){
                $erreurs[] = "le titre est vide .....!";
            }
            if(isset($_POST['text'])&& empty($_POST['text'])){
                $erreurs[] = "le text est vide .....!";
            }

            //assianir les variable 
            if(!empty($_GET['id'])){
                $id_categorie = $_GET['id'];
            }
            if(!empty($_SESSION['idClient'])){
                $idClient = $_SESSION['idClient'];
            }
            if(!empty($_POST['titre'])){
                $titre = $_POST['titre'];
            }
            if(!empty($_POST['text'])){
                $text = $_POST['text'];
            }

            if(empty($erreurs)){
                
                $requetAjouterSujet = "insert into message (titre,text,id_categorie,id_user) values('$titre','$text','$id_categorie','$idClient')";
                mysqli_query($link,$requetAjouterSujet);
                $id =mysqli_insert_id($link);
                if($id ==0){
                    echo "ajout du sujet échoué...!";
                }
            }
            
        }
    // récupérer les les sujets pour le forum choisi es ses réponses 
    $requeteForum = "select m.id,m.titre,m.date as date_creation_sujet, count(r.id)as num_reponse, max(r.date) as derniere_reponse from message m left join  reponse r on m.id= r.id_message where id_categorie =".$_GET['id']." group by m.titre";
    $resultat = mysqli_query($link,$requeteForum);
    if($resultat){
        echo "<table><th>sujet</<th><th>date de création</th><th>nombre de réponse</th><th>date de derniere réponse</th>";
        echo "<h3>liste des sujets pour ".$_GET['forum']."</h3>";
        while($ligne_resultat = mysqli_fetch_assoc($resultat)){
            echo "<tr>";
            echo "<td><a href=\"/sujet.php?id=".$ligne_resultat['id']."&id_forum=".$_GET['id']."&titre_sujet=".$ligne_resultat['titre']."\">".$ligne_resultat['titre']."</a></td><td>/".$ligne_resultat['date_creation_sujet']."/</td><td>".$ligne_resultat['num_reponse']."</td><td>".$ligne_resultat['derniere_reponse']."</td></tr>";
        }
        echo "</table><br><br>";
        
    } else {
        $erreurs[] = "aucun sujet ou erreur de connexion ...!";
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
            <form method="POST">
                <input type="text" name="titre" placeholder="titre de sujet"/><br>

                <textarea name="text" placeholder="message de sujet"></textarea><br>
                <button type="submit" name="nouveauSujet">Nouveau sujet</button>
            </form>

            <form method="POST">
            <button type="submit" name="deconn">se déconnecter</button>
            </form>
            <button><a href="/indexConnecte.php">retour</a></button>
    </body>
</html>