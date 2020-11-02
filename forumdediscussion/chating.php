<?php
session_start();
include_once 'connexionbdd.php';

$erreurs = [];
//récupérer le donnés saisie par l'utilisateur
    // récupérer le pseudo  
    if(isset($_POST['pseudo']) && isset($_POST['message'] )){
        $pseudo = strip_tags($_POST['pseudo']);
    
    // récupérer la message 
    
        $message = strip_tags($_POST['message']);

          //préparer la requete 
          if(!empty($pseudo) && !empty($message)){
    $requete = "insert into pseudo (pseudo, message) VALUES ( '$pseudo', '$message' ); ";
    
    // insérer des message pour le pseudo saisie par l'utilisateur 
        mysqli_query($link,$requete);
        
                }


    }

    $requetSelect = "select * from pseudo order by date asc limit 20";
    $result = mysqli_query($link,$requetSelect);
    echo "<div><h1> Chating</h1><br>";
    if(!empty(($_GET['param']))){
        echo "vous êtes connecté";
    }
    echo"<ul>";
    if($result){
    while($ligne_resultat = mysqli_fetch_assoc($result)){
        echo"<li>";
        echo "pseudo : ".$ligne_resultat['pseudo']." / message :   ".$ligne_resultat['message']." / date :  ".$ligne_resultat['date']."<br>"; 
        echo "</li>"; 
    }
}else{
    $erreurs[] = "pas de messages sauvgardées ou erreur de connexion..!";
}
        echo "</ul></div>";
  
    mysqli_close($link);
    

    if(isset($_POST['deconn'])){
        session_destroy();
        header("Location: http://localhost/forumdiscussion/index.php");
        exit();

    }

    //redirection vers la page de modification 
    if(isset($_POST['Modifier'])){
        header("Location: http://forumdiscussion/modifier.php");
        exit();

    }

   
   
?>
<html>
    <head>

    </head>
    <body>
    <?php
            if(count($erreurs)){
                echo "<ul>";
                for($i = 0;$i<count($erreurs);$i++){
                    echo "<li>".$erreurs[$i]."</li>";
                
                }
                echo "</ul>";
            }
            
            ?>
    <form method="POST" action="#">
<input type="text" name="pseudo" placeholder="votre pseudo"  /><br><br>
<textarea name="message" placeholder="votre message ici ">  </textarea><br><br>
<input type="submit"  value="envoyer"/>



</form>
<form method="POST">
<button type="submit" name="deconn">se déconnecter</button>
</form>

<form method="POST">
<button type="submit" name="Modifier">Modifier votre profil </button>
</form>

    </body>
</html>

   
   




