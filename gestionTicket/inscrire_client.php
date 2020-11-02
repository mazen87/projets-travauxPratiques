<?php
    session_start();
    require_once 'connexionbdd.php';
    mysqli_set_charset($link, "utf8");

    //déclaration des variables 
    $nom = "";
    $email = "";
    $testMotDePasse = "";
    $motDePasse = "";
    $confMotDePasse ="";
    $erreurs = [];  

    if(isset($_POST['inscrire'])){

        // verification des saisies et assainir  les variables
        if(!empty($_POST['nom'])){
            $nom = htmlspecialchars(trim(stripslashes(strip_tags($_POST['nom']))));
        }else{
            $erreurs[] = "nom est vide ...!";
        }

        if(!empty($_POST['email'])){
            $email = htmlspecialchars(trim(stripslashes(strip_tags($_POST['email']))));
        }else{
            $erreurs[] = "email est vide ...!";
        }

        if(!empty($_POST['passwordInsc'])){
           $testMotDePasse =  password_hash($_POST['passwordInsc'],PASSWORD_DEFAULT);
        }else{
            $erreurs[] = "mot de passe est vide ...!";
        }

        if(!empty($_POST['confpasse'])){
            $confMotDePasse =  $_POST['confpasse'];
        }else{
            $erreurs[] = "la confiramtion du mot de passe est vide ...!";
        }

        if(!empty($_POST['confpasse']) && !empty($_POST['passwordInsc'])){
            if(password_verify($confMotDePasse,$testMotDePasse)){
               $pattern = '/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/';
                if(preg_match($pattern,$confMotDePasse)){
                    $motDePasse =  password_hash($_POST['passwordInsc'],PASSWORD_DEFAULT);
                }else{
                    $erreurs[] = "le mot de passe doit avoir :
                    au moins 1 caractère en majuscule 
                    au moins 1 caractère en minuscule
                    au moins 1 chiffre
                    au moins 8 de longueur
                    au moins 1 caractère spécial";
                }
               
            }else{
                $erreurs[] = "les mots de passes ne correspondent pas...!";

            }
        }

        // ajouter un nouveau client à la base de données
        if(empty($erreurs)){
            //préparation la requête d'insertion 
            $requete_insertion_client = "INSERT INTO utilisateur (nom,email,mot_de_passe) VALUES('$nom','$email','$motDePasse')";
            //exécuter la requête 
            mysqli_query($link,$requete_insertion_client);
            $id_nouveau_utilisateur = mysqli_insert_id($link);
            if($id_nouveau_utilisateur != 0){
                $_SESSION['idClient'] = $id_nouveau_utilisateur;
                header("Location: http://gestionticket/client_connecte.php");
                die();
            }else {
                $erreurs[] = "insertion echouée ou email déja utilisé.... !";
            }
        }



    }
?>

<html>
    <head>
    </head>
    <body>
    <h1>Gestion de Tickets</h1>
    <ul>
    <?php 
        for($i=0;$i<count($erreurs);$i++){
            echo "<li>".$erreurs[$i]."</li>";
        }
    ?>
    </ul>
            <form method="POST">
                <input type="text" name="nom" placeholder="toto..." />
                <input type="mail" name="email" placeholder="xxx@exemple.com"/>
                <input  type="password" name="passwordInsc" placeholder="mot de passe" />
                <input  type="password" name="confpasse"  placeholder="confirmation mot de passe">
                <input type="submit" value="s'inscrire" name="inscrire"/>
            </form>
        <button><a href="/connexion_utilisateur.php">retour</a></button>
    </body>
</html>