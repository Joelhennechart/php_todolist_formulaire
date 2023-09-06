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
     //Je vérifie que j'ai bien récupèré l'id de l'article dans le super variable globale $_GET,
    // sinon je redirige l'utilisateur vers la page connected.php
     if(isset($_GET['id']) && !empty($_GET['id'])){
         //Je stocke l'id de l'article dans une variable puis je fais ma requète SELECT
         $idArticle = htmlspecialchars($_GET['id']);
         $rqt ='SELECT article.title, article.content, article.creation_date, user.login 
         FROM article LEFT JOIN user on article.author = user.id WHERE article.id = :idArticle';
      //pour récupèrer les 5 dernier articles dont l'utisateur est l'hauteur//  
         $db_statement = $db_connexion->prepare($rqt);
         $db_statement->execute(
             array(
                 ':idArticle' => $idArticle
             )
        ); 
        $article = $db_statement->fetch(PDO::FETCH_ASSOC);
        // Si l'id est absent de la BDD, l'utilisateur est redirigé vers connected 
        $nb = $db_statement-> rowCount();
        if ($nb <= 0) {
            header('location:connected.php');
        }   
        // $article['creation_date'] est de type String. Je stocke cette date dans
        // la variable $date pour avoir un format JJ/MM/AA
        $date = new DateTimeImmutable($article['creation_date']);
        $date = date_format($date, "d/m/y");

    } 
        else {
            header('location:connnected.php');
        }
    
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Retrouvez dans cette page le detail de votre article.">
    <title>Lire un article</title>
    <link rel="stylesheet" href="/styles/main.css">
</head>
<body>
    <!-- Ma navBar est importée -->
<?php 
    require_once('./includes/navBar.php');
  // Ma navBar todolist est importée //

require_once('./includes/todolist_navBar.php');
?>

<article class="container">
    <h1><?php echo(htmlspecialchars($article[('title')])) ?> </h1>
    <p class="todolist_content">
        <?php echo(htmlspecialchars($article['content'])); ?> 
    </p>
    <div class="todolist_footer">
        <div class="todolist_footer_content">
            Auteur :<?php echo(htmlspecialchars($article['login']))?>
        </div>
        <div class="todolist_footer_content">
            Edité le :<?php echo(htmlspecialchars($date))?>
        </div>
    </div>
</article>
    
</body>
</html>