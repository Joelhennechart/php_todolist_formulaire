<?php

// Création d'une instance PDO (Php Data Object) pour se connecter à ma bdd: mapropositionvalphp//

$dsn ="mysql:host=localhost;dbname=mapropositionvalphp;charrset=utf8"; //chemin veers la BDD//
$user= "root";
$password= "root";
try{
    //si tout va bien//
    $db_connexion = new PDO($dsn, $user,$password);
    $db_connexion->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8');
    $db_connexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); //gerer le tableau associatif de la BDD
    $db_connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //gerer les erreurs
    // :: veut dire l'enfant depend de son parent est recupére quelque chose de son parent 
}
catch(PDOException $e){
    //si une erreur est levée//
    echo('Impossible d\'accéder a la base de données');

}