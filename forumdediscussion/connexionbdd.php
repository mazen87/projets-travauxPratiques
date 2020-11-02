<?php 
    $basedd = "forumdiscussion";
    $adresseIp = "127.0.0.1";
    $password = "";
    $username = "root";

    $link = mysqli_connect($adresseIp, $username, $password, $basedd);

    if (!$link) {
        echo "Erreur : Impossible de se connecter à MySQL." . PHP_EOL;
        echo "Errno de débogage : " . mysqli_connect_errno() . PHP_EOL;
        echo "Erreur de débogage : " . mysqli_connect_error() . PHP_EOL;
        exit;
    }
    
    echo "Succès : Une connexion correcte à MySQL a été faite! La base de donnée $basedd." . PHP_EOL;
    echo "Information d'hôte : " . mysqli_get_host_info($link) . PHP_EOL."<br><br>";

    