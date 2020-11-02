<?php
    session_start();
    require_once 'connexionbdd.php';
    mysqli_set_charset($link, "utf8");

    // déclarer les variable 
    $email = "";
    $motdepasse = "";
    $erreursConn = []; 

     //assainir les variables 
     if(isset($_POST['mail'])){
        $email = htmlspecialchars(trim(stripslashes(strip_tags($_POST['mail']))));
    }
    if(isset($_POST['motpasse'])){
        $motdepasse = $_POST['motpasse'];
    }
     // traiter le post 
     if(isset($_POST['connecter'])){
        //gérer les erreurs 
        if(empty($_POST['mail'])){
                $erreursConn[] = "email est vide...!";
        }
        if(empty($_POST['motpasse'])){
            $erreursConn[] = "mot de passe est vide...!";
        }    

        if(empty($erreursConn)){
            //préparer la requête 
            //echo 1 ;
            $requeteConnexion = " select * from utilisateur where email like '$email'";
            $resultatConn = mysqli_query($link,$requeteConnexion);
            if($resultatConn){
                //echo 2 ;
                if(mysqli_num_rows($resultatConn)){
                   // echo 3 ;
                $ligneResultatConn = mysqli_fetch_assoc($resultatConn);
                //tester le mot de passe 
                if(password_verify($motdepasse,$ligneResultatConn['mot_de_passe'])){
                   // echo 4 ;
                   if($ligneResultatConn['statut'] == "client"){
                    $_SESSION['idClient'] = $ligneResultatConn['id'];
                    $_SESSION['nom'] = $ligneResultatConn['nom'];

                    header("Location: http://gestionticket/client_connecte.php");
                    exit();
                   }else{
                    $_SESSION['idtech'] = $ligneResultatConn['id'];
                    $_SESSION['nom'] = $ligneResultatConn['nom'];
                    header("Location: http://gestionticket/connexion_tech.php");
                    exit();
                   }
                    
                   
                  
                   
                }else{
                    $erreursConn[] = "login ou mot de passe incorrect ou inexistant...!";    
                }

            }else{
                $erreursConn[] = "login ou mot de passe incorrect ou inexistant...!";
            }
            }else{
                $erreursConn[]= "erreur requête....!";
        }
        }

     }

   // $motdepassehache = password_hash("aaaa",PASSWORD_DEFAULT);
   // echo $motdepassehache;
?>
<html>
<head>
</head>
<body>
<h1> Gestion de Tickets </h1>
    <ul>
    <?php
    for ($i=0;$i< count($erreursConn);$i++){
        echo "<li>".$erreursConn[$i]."</li>";
    }
    ?>
    </ul>
<form method="POST">
    <h3>Connexion</h3>
<input type="mail" placeholder="xxx@exemple.com" name="mail" />
<input type="password" name="motpasse" placeholder="mot de passe ....."/>
<input type="submit" value="se connecter" name="connecter"/>
</form>
<a href="/inscrire_client.php"> s'inscrire comme client </a>
</body>
</html>
