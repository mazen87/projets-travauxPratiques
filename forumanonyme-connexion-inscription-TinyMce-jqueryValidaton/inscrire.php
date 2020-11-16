<?php
    session_start();
    require_once 'connexionBDD.php';
    require_once 'utilisateur.php';
    $connexionBDD =new Connexionbdd("localhost","root","","forumanonyme");


    //déclaration des variables 
    $utilisateur = new Utilisateur();
    $confMotDePasse ="";
    $testMotDePasse ="";
    $erreurs = [];  

    if(isset($_POST['inscrire'])){

        // verification des saisies et assainir  les variables
        if(!empty($_POST['pseudo'])){
            $utilisateur->pseudo = htmlspecialchars(trim(stripslashes(strip_tags($_POST['pseudo']))));
        }else{
            $erreurs[] = "pseudo est vide ...!";
        }

        if(!empty($_POST['email'])){
            $utilisateur->email = htmlspecialchars(trim(stripslashes(strip_tags($_POST['email']))));
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
                    $utilisateur->motDePasse =  $testMotDePasse;
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
            $requete_insertion_utilisateur = "INSERT INTO utilisateur (pseudo,email,motDePasse) VALUES(?,?,?)";
            $stmt = $connexionBDD->connexion->prepare($requete_insertion_utilisateur);
            $stmt->bind_param("sss",$p_pseudo,$p_email,$p_motDePasse);
            $p_pseudo = $utilisateur->pseudo;
            $p_email = $utilisateur->email;
            $p_motDePasse = $utilisateur->motDePasse;
            $stmt->execute();
            $id=0;
            $id = $connexionBDD->connexion->insert_id;
            if($id != 0){
                $utilisateur->id = $id;
                $_SESSION['id_utilisateur'] = $utilisateur->id;
                header("Location: accueil_utilisateur.php");
                die();
            }else {
                $erreurs[] = "insertion echouée ou email déja utilisé.... !";
            }
        }



    }
?>

<html>
    <head>
        <script src="jquery-3.5.1.min.js"></script>
        <script src="jquery-validation-1.19.2/dist/jquery.validate.js"></script>
        <script src="jquery-validation-1.19.2/dist/localization/messages_fr.js"></script>
        <script>
            $(function(){
                $("#inscription").validate({
                        rules: {
                            pseudo: {
                                minlength: 10,
                                required : true
                            },
                            email:{
                                required : true,
                                email : true
                            },
                            passwordInsc : {
                            minlength :8,
                            required: true,
                            validateMotDePasse : true
                            },
                            confpasse: {
                                required : true,
                                minlength : 8,
                                equalTo : "#passwordInsc"
                            }


                        },
                       
                });

                jQuery.validator.addMethod("validateMotDePasse",function(value,element){
                    return this.optional( element ) ||/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/.test( value );
                },"le mot de passe doit avoir, au moins 1 caractère en majuscule, au moins 1 caractère en minuscule, au moins 1 chiffre,  au moins 8 de longueur,  au moins 1 caractère spécial");
            });

        </script>
    </head>
    <body>
    <h1>Forum anonyme</h1>
    <h2>Inscription</h2>
    <ul>
    <?php 
    /*
        for($i=0;$i<count($erreurs);$i++){
            echo "<li>".$erreurs[$i]."</li>";
        }
        */
    ?>
    </ul>
            <form method="POST" id="inscription">
                <input type="text" name="pseudo" placeholder="pseudo..." />
                <input name="email" placeholder="xxx@exemple.com"/>
                <input id="passwordInsc" type="password" name="passwordInsc" placeholder="mot de passe" />
                <input  type="password" name="confpasse"  placeholder="confirmation mot de passe">
                <input type="submit" value="s'inscrire" name="inscrire"/>
            </form>
        <button><a href="index.php">retour</a></button>
    </body>
</html>

