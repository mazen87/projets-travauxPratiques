
    // les définition avec exemples : 
    /**
     * les variable : c'est une espace de mémoire dans laquelle
     *  on peut stocker les données afin de pouvoir les utilisées après ,
     * avec la possibilité de changer la valeur de cette variable pendant sa cicle de vie . 
     * exemples : 
     *  */ 
    let nom = "wiliam";  // valeur de type chaine de caractère
    var nombre = 3;      // valeur de type numérique
    /**
     * 
     */

     /**
      * les constantes : c'est on espace de mémoire dans laquelle on peut stocker les données 
      *afin de pouvoir les utilisées après,
      * mais une fois affecté une valeurà la constante on oeut pas la changer après.
      *
      * exemples : 
      */
       const premier_jour_de_semaine = "lundi";
      /**
       * les structures de controle : des outils(statement) permettant de faire un traitement précise pour réaliser un comportement 
       * souhaité par le system.
       * exemples : les boucles (for, while,do while....) : permettre de réaliser un comportement itératif.
       *            les conditions (if, else if , else, switch) : permettre de réaliser un comportement conditionnel. 
       */
        for(i=0; i <10 ;i++)//la condition de boucle
        {
                console.log("le numéro actuel est");  // les instruction à exécuter tant que la condition retourne vrai 
        }

        /**
         * les types de variable : chaine de caractère , entier, float(nombre avec vergule) ,
         * booléan(false/true),null(pas de valeur),tableux(associatif,normal),objet(programmation orientée objet)
         * exemble : 
         */
        let nombre_entier = 1;//entier
        let nobre_vergule = 2.33;//float
        let pas_de_valeur;//null
        let est_valide = true;//booléan
        let les_jours = ["lundi","mardi","mercredi","jeudi","vendredi","samdi","dimanche"];//normal
        let valeurs = {"valeur1": 44,"valeur2": 55};//associatif
        let personne1 = {
               prenom : 'william',
               nom    : 'lemoine',
               age    : '11/01/1980',
               metier : 'développeur web'
             }

        /**
         * les fonctions : block de construction ayant un nom peut prendre des paramètres permettant de réaliser un comportement précis
         * et retourne une seule valeur  par appeler le nom de cette fonction   
         * 
         * les paramètres : des variable que la fonction attend en la appelant pour les utiliser dans son block de constructions
         * exemple :
         */
        function adition (valeur1,valeur2)//les paramètres 
        {
            return valeur1 +valeur2;             // block d'instruction (comportement de la fonction )
        }

        adition(3,4); // return 7

        /**
         * les procédures : block de construction ayant un nom peut prendre des paramètres permettant 
         * de réaliser un comportement précis et ne retourne aucune valeur
         * exemple
         */
        function afficherHello ()
        {
            console.log(" hello !");
        }

        /**
         * concatination : permettre d'assovier plusieurs chainede caractères dans une seule chaine 
         * et permettre de passer une valeur de variable dans une chaine de caractère 
         * exemple : 
         */
        let nom = "wiliam";
        console.log("bienvenu "+nom+" sur notre site"); // rendu : bienvenu wiliam sur notre site

