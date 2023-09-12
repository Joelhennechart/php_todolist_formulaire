<?php
    session_start();
    // J'inclus une connexion vers ma BDD
    include('./model/db_connexion.php');
      /**
     * Je verifie si j'ai bien un userID dans la session, sinon je redirige vers index.php
     */
        if(!isset($_SESSION['userID'])){
            header('location:index.php');
            exit;}
        else {
            $userID = $_SESSION['userID'];
            }
    /**  Todo : En BDD, je récupère les 5 articles les plus recents dont l'utiisateur est l'auteur.
           * ILs sont :
            *-trier du plus récent au plus anciens
            * L'utilisateur doir être l'auteur */
    $rqt ='SELECT id, title FROM article WHERE author = :userID ORDER BY creation_date DESC LIMIT 5';
     //pour récupèrer les 5 dernier articles dont l'utisateur est l'hauteur//  
        $db_statement = $db_connexion->prepare($rqt);
        $db_statement->execute(
            array(
                ':userID' => $userID
            )
    );
    $datas = $db_statement->fetchAll();
    
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Bienvenu dans votre espace personnel Retrouvez ici vos 5 articles les plus récents !">
    <title>Accueil connecté - 5 articles</title>
    <link rel="stylesheet" href="/styles/main.css">
</head>
<body>
   
<!-- Ma navBar est importée -->
<?php 
    require_once('./includes/navBar.php');
  // Ma navBar todolist est importée //
?>   
<!--Afficher les 5 articles que je viens de récupèrer -->
<?php
    foreach($datas as $data){
        echo('
        <div class="card">
            <a href="read_article.php?id='. $data['id'] .'" class="article">
                <div class="info">
                    '. $data['title'] .'
                </div>
            </a>
        </div>
        ');
    }
?> 
</body>
</html>