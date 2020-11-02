<?php
    session_start();
    require_once 'connexionbdd.php';

?>

<html>
    <head>
    </head>
    <body>
    <h1>Gestion de Tickets</h1>
            <form method="POST">
                <lable>pseudo :</lable><input type="text" name="loginInsc" placeholder="toto..." /><br><br>
                <label>Email : </label><input type="mail" name="email"/>   <br><br>
                <label>Mot de passe :</label><input  type="password" name="passwordInsc"  ><br><br>
                <label>confirmation Mot de passe :</label><input  type="password" name="confpasse"><br><br>
                <input type="submit" value="s'inscrire" name="inscrire"/>
            </form>
        <button><a href="/index.php">retour</a></button>
    </body>
</html>