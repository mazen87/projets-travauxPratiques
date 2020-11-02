<?php
    session_start();
    require_once 'connexionbdd.php';
    $id = 0;
    $id = $_SESSION['idClient'];
    echo $id;
    $erreurs = [];
    
    //récupérer les données pour l'utilisateur connecté 
    //préparer la requête 
    $requeteDonneesUtilisateur = "select * from user where id = '$id'";
    $resultat = mysqli_query($link,$requeteDonneesUtilisateur);
        if($resultat){
            if(mysqli_num_rows($resultat)){
                $ligne_resultat = mysqli_fetch_assoc($resultat);
            }else{
                $erreurs = "erreur de connexion...!";
            }
        }else {
            $erreurs[] = "erreur de connexion...!";
        }

        //la modification 
         // déclarer les variable 
     $loginInsc = "";
     $passInsc = "";
     $passConf ="";
     $email ="";
     $erreurs = [];
     $messages = [];
     $idClient =0;
     $param =0;

      //assainir les variable 
      if(isset($_POST['loginInsc'])){
        $loginInsc = htmlspecialchars(trim(stripslashes(strip_tags($_POST['loginInsc']))));
    }
    
    if(isset($_POST['passwordInsc'])){
        $passInsc = password_hash($_POST['passwordInsc'],PASSWORD_DEFAULT);
    }
    if(isset($_POST['confpasse'])){
        $passConf = $_POST['confpasse'];
    }

     //traiter le post 
     if(isset($_POST['modifier'])){
        if(empty($_POST['loginInsc'])){
            $erreurs[]="le pseudo est vide ....!";
        }
       
         if(empty($_POST['passwordInsc'])){
            $erreurs[] = "le mot de passe est vide...!";
        }
        if(empty($_POST['confpasse'])){
            $erreurs[]= "le confirmation est vide.....!";
        }
        if(!password_verify($passConf,$passInsc)){
            $erreurs[] ="les mot de passes ne correspondent pas...!"; 

        }
        if(password_verify($passConf,$passInsc)){
                  // tester le mot de passe respect les régles suivantes
               $pattern = '/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/';
               //$testPass = preg_match($pattern,$passConf);
              
               if(preg_match($pattern,$passConf)==0 || preg_match($pattern,$passConf == false) ){
                   $erreurs[] = "le mot de doit avoir :
                   au moins 1 caractère en majuscule 
                   au moins 1 caractère en minuscule
                   au moins 1 chiffre
                   au moins 8 de longueur
                   au moins 1 caractère spécial";
        }
        
        }
        
        

        if(empty($erreurs)){
              // préparer la requête 
              $requeteInscription = "update user set  pseudo = '$loginInsc',motdepasse ='$passInsc' where id=".$_SESSION['idClient'];
              $resultat = mysqli_query($link, $requeteInscription);
           
            if($resultat){
                $messages[] = "modification réussie...";
              //$idClient = mysqli_insert_id($link);
             /* if($idClient != 0){
                $_SESSION['idClient'] = $idClient;
                $param =  $_SESSION['idClient'];
                header("Location: http://forumdiscussion/chating.php?param=$param");
            exit();
              }*/
              
        }else{
            $erreurs = "modification échouée...!";
        }

        }
    }


        //se déconnecter 
        if(isset($_POST['deconn'])){
            session_destroy();
            header("Location: http://localhost/forumdiscussion/index.php");
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
             <?php
            if(count($messages)){
                echo "<ul>";
                for($i = 0;$i<count($messages);$i++){
                    echo "<li>".$messages   [$i]."</li>";
                
                }
                echo "</ul>";
            }
            
            ?>
        <div>
        <h2>Modivier votre profil</h2>
            <form method="POST">
                <p><label>Email : </label><?=$ligne_resultat['email']?></p>
                <lable>pseudo :</lable><input type="text" name="loginInsc" placeholder="toto..." value="<?=$ligne_resultat['pseudo']?>" /><br><br>
                  
                <label>Mot de passe :</label><input  type="password" name="passwordInsc"  ><br><br>
                <label>confirmation Mot de passe :</label><input  type="password" name="confpasse"><br><br>
                <input type="submit" value="Modifier" name="modifier"/>


            </form>
        </div>
        
        <div>
        </form>
<form method="POST">
<button type="submit" name="deconn">se déconnecter</button>
</form>
</div>
<button><a href="/indexConnecte.php">retour</a></button>
    </body>
</html>