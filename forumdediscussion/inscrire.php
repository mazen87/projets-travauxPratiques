<?php
    session_start();
    require_once 'connexionbdd.php';

     // déclarer les variable 
     $loginInsc = "";
     $passInsc = "";
     $passConf ="";
     $email ="";
     $erreurs = [];
     $idClient =0;
     $param =0;
 
     //assainir les variable 
     if(isset($_POST['loginInsc'])){
         $loginInsc = htmlspecialchars(trim(stripslashes(strip_tags($_POST['loginInsc']))));
     }
     if(isset($_POST['email'])){
         $email = htmlspecialchars(trim(stripslashes(strip_tags($_POST['email']))));
     }
     if(isset($_POST['passwordInsc'])){
         $passInsc = password_hash($_POST['passwordInsc'],PASSWORD_DEFAULT);
     }
     if(isset($_POST['confpasse'])){
         $passConf = $_POST['confpasse'];
     }
 
     //traiter le post 
     if(isset($_POST['inscrire'])){
         if(empty($_POST['loginInsc'])){
             $erreurs[]="le login est vide ....!";
         }
         if(empty($_POST['email'])){
             $erreurs[] = "email est vide ....!";
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
                if(preg_match($pattern,$passConf)== 0 || preg_match($pattern,$passConf) == false ){
                    
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
               $requeteInscription = "insert  into user (pseudo,motdepasse,email) values('$loginInsc','$passInsc','$email') ;";
               mysqli_query($link, $requeteInscription);
 
               $idClient = mysqli_insert_id($link);
               if($idClient != 0){
                       $_SESSION['idClient'] = $idClient;
                       $_SESSION['pseudo'] = $loginInsc;
                 $param =  $_SESSION['idClient'];
                 header("Location: http://forumdiscussion/indexConnecte.php?param=$param");
             exit();
               }
               
         }
 
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

        <div>
        <h2>Inscription</h2>
            <form method="POST">
                <lable>pseudo :</lable><input type="text" name="loginInsc" placeholder="toto..." /><br><br>
                <label>Email : </label><input type="mail" name="email"/>   <br><br>
                <label>Mot de passe :</label><input  type="password" name="passwordInsc"  ><br><br>
                <label>confirmation Mot de passe :</label><input  type="password" name="confpasse"><br><br>
                <input type="submit" value="s'inscrire" name="inscrire"/>


            </form>

        </div>
        <button><a href="/index.php">retour</a></button>
    </body>
</html>