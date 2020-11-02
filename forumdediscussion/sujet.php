<?php
session_start();
require_once 'connexionbdd.php';

$erreurs=[];
$text ="";
$idSujet = 0;
$idClient =0;

?>
<html>
    <head>
        <meta  charset="UTF-8">
    </head>
    <body>

    <h1> bienvenu <?php echo $_SESSION['pseudo']?> sur le site Forum de Discussion</h1>
    <?php

if(isset($_POST['repondre']) && empty($_POST['text'])){
    $erreurs[] = "le text est vide ..!";
}
//ajouter une réponse 
if(isset($_POST['text'])){
$text =$_POST['text'];
    }
    if(!empty($_GET['id'])){
$idSujet =$_GET['id'];
            }
     if(!empty($_SESSION['idClient'])){
$idClient =$_SESSION['idClient'];
            }
if(isset($_POST['repondre']) && !empty($_POST['text'])){
    $requetAjouterRepondre = "insert into reponse (text,id_message,id_user) values ('$text','$idSujet','$idClient')";
    mysqli_query($link,$requetAjouterRepondre);
    $idReponse = mysqli_insert_id($link);
    if($idReponse ==0){
        echo "ajout de réponse échoué...!";
    }

}
        //récupérer les réponses 
$requeteReponse = "select * from reponse where id_message =".$_GET['id']." order by date desc";
$resultat = mysqli_query($link,$requeteReponse);
if($resultat){
    echo "<h3>liste des réponses pour ".$_GET['titre_sujet']."</h3>";

    echo "<table><th>text de reponse</<th><th>date de reponse</th>";
    while($ligne_resultat = mysqli_fetch_assoc($resultat)){
        echo "<tr>";
        echo "<td>".$ligne_resultat['text']."</td><td>/".$ligne_resultat['date']."</td></tr>";

    }
    echo "</table><br><br>";

}else{
    $erreurs[] = "aucune réponse ou erreur de connexion...!";
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
                <textarea name="text"></textarea>
                <button type="submit" name="repondre"> Répondre</button>
            </form>
         <form method="POST">
            <button type="submit" name="deconn">se déconnecter</button>
            </form>
            <?php $id = $_GET['id_forum']?>
    </body>
</html>