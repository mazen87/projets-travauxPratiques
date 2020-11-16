<?php
session_start();
require_once 'connexionBDD.php';
require_once 'utilisateur.php';
$connexxionbdd = new Connexionbdd("localhost","root","","forumanonyme");
$erreursConn = array();
$motDePasse="";
$utilisateur = new Utilisateur();
      //assainir les variables 
      if(isset($_POST['email'])){
        $utilisateur->email= htmlspecialchars(trim(stripslashes(strip_tags($_POST['email']))));
    }
    if(isset($_POST['motDePasse'])){
        $motDePasse = $_POST['motDePasse'];
    }
     // traiter le post 
     if(isset($_POST['connexion'])){
        //gérer les erreurs 
        if(empty($_POST['email'])){
                $erreursConn[] = "email est vide...!";
        }
        if(empty($_POST['motDePasse'])){
            $erreursConn[] = "mot de passe est vide...!";
        }    

        if(empty($erreursConn)){
            //préparer la requête 
            //echo 1 ;
            $requeteConnexion = " SELECT id,email,pseudo,motDePasse FROM utilisateur where email LIKE ? ";
            $stmt = $connexxionbdd->connexion->prepare($requeteConnexion);
            $stmt->bind_param("s",$p_email);
            $p_email = $utilisateur->email;
            $p_motDePasse = $utilisateur->motDePasse;
            $stmt->execute();
            $stmt->bind_result($r_id_utilisateur,$r_email,$r_pseudo,$r_motDePasse);  
            $stmt->fetch();
            $utilisateur = Utilisateur::const_rempli_utilisateur($r_id_utilisateur,$r_email,$r_pseudo,$r_motDePasse);
            if(!empty($utilisateur)){
                //echo 2 ;
                if($utilisateur->id !=0){
                    if(password_verify($motDePasse,$utilisateur->motDePasse)){
                   // echo 3 ;
                    $_SESSION['id_utilisateur'] = $utilisateur->id;
                    $_SESSION['pseudo'] = $utilisateur->pseudo;
                    header("Location:  accueil_utilisateur.php");
                    exit();
                }else{
                    $erreursConn[] = "login ou mot de passe incorrect ou inexistant...!";
                }
                /*
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
                */
            }else{
                $erreursConn[] = "login ou mot de passe incorrect ou inexistant...!";
            }
            }else{
                $erreursConn[]= "erreur de connexion!";
        }
        }
     }
?>
<html>
    <head>
        <script src="jquery-3.5.1.min.js"></script>
        <script src="jquery-validation-1.19.2/dist/jquery.validate.js"></script>
        <script>
            $(function(){
                $("#connexion").validate({
                    rules: {
                        email : {
                            required :true,
                            email : true
                        },
                        motDePasse : {
                            
                            required: true,
                           
                        }
                    }
                });
               
            });

        </script>

    </head>
    <body>
        <h1>Forum anonyme</h1> 
        <h2>Connexion</h2>
        <ul>
    <?php
    
    for ($i=0;$i< count($erreursConn);$i++){
        if($erreursConn[$i]=="login ou mot de passe incorrect ou inexistant...!"){
        echo "<li>".$erreursConn[$i]."</li>";
    }
    
    }
        
    ?>
    </ul>
        <form method="POST" id="connexion">
            <input placeholder="email@exemple.com" name="email"/>
            <input type="password" name="motDePasse"/>
            <input type="submit" value="se connecter" name="connexion"/>
        </form>

        <a href="inscrire.php"> s'inscrire </a>
    </body>
</html>