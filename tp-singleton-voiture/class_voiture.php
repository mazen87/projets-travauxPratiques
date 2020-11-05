<?php
    require_once 'voiture.php';
    $voiture1 = Voiture::construit_singleton("mazda","bleu");
    $voiture2 = Voiture::construit_singleton("mercedes","blanche");
    echo $voiture1->couleur;
    echo $voiture2->couleur;
