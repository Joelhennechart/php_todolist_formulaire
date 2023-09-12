<?php
    session_start();
    include('./model/db_connexion.php');

    if(!isset($_SESSION['userID'])){
        header('location:index.php');
        exit;}
    else {
        $userID = $_SESSION['userID'];
        }
    // Création de constantes qui contiennent les erreurs possibles


const ERROR_REQUIRED = 'Veuillez renseigner ce champs.';

// initialisation d'un tableau contenant les erreurs possibles lors des saisies//
    $errors = [
    'title' => '',
    'content' => '',
    ];
    $message = '';
     //Je vérifie que j'ai bien récupèré l'id de l'article dans le super variable globale //
    if(isset($_GET['id']) && !empty($_GET['id'])){
        $idArticle = htmlspecialchars($_GET['id']);
        $rqt ='SELECT title, content FROM article  WHERE id = :idArticle'; 
        //Dans le Select les , ont 1 sens SELECT title, content veut dire que je selectionne que la colonne title et content.
        // Si je met une , derriere content ça veut dire que je veux selectionner une 3ieme colonne.
         $db_statement = $db_connexion->prepare($rqt);
         $db_statement->execute(
             array(
                 ':idArticle' => $idArticle
             )
        ); 
        $article = $db_statement->fetch(PDO::FETCH_ASSOC);
    }

    else {
        header('location:connnected.php');
        }
    //Traitement des données si la methode est bien POST//
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $_POST = filter_input_array(
        INPUT_POST,[
        'title' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        'content' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        ]
        );
    //Initiation des variables qui vont recevoir les champs du formulaire//
    $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';
    // remplissage du tableau concernant les erreurs possibles
    if(!$title){
        $errors['title'] = ERROR_REQUIRED;
    }
    if(!$content){
        $errors['content'] = ERROR_REQUIRED;
    }
    //execution de la requète INSERT into
    if(($title) && ($content)) {
        //execution de la requéte INSERT INTO
        $rqt = "UPDATE article SET title = :title, content = :content WHERE id = :idArticle ";
        $db_statement = $db_connexion->prepare($rqt);
        $db_statement->execute(
            array(
                ':title' =>$title,
                ':content'=>$content,
                ':idArticle'=>$idArticle,
            ));
            header('location:connected.php');
    }
    else{
        $message = "<span class = 'message'> Veuillez renseigner tous les champs ! </span>";
        }}
    ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Créer ici un nouvel article">
    <title>Créer un nouvel article</title>
    <link rel="stylesheet" href="/styles/main.css">
</head>
<body>
    <!-- Ma navBar est importée -->
<?php 
    require_once('./includes/navBar.php');
?>
        <section class="container">
            <div class="form-container">
                <!-- Formulaire pour ajouter un nouvel article -->
                <h1>Modifiez votre article !</h1>    
                <form action="#" method="POST">
                    <div class="form-control">
                        <input type="text" name="title" id="title" value="<?=
                         htmlspecialchars($article['title']) ?>">
                         <!-- Inserez les messages d'erreur et succés-->
                        <?= $errors['title'] ? '<p class="text-error">'. $errors['title'] .'</p>' : '' ?> 
                        <!-- dans une balise entre (? '...' :) boolean si vrais on execute  ? '<p class="text-error">'. $errors['title'] .'</p>' si faux on execute  '' -->
                    </div>
                    
                    <div class="form-control">
                        <textarea rows="5" name="content" id="content" placeholder="votre contenu détaillé ici..."></textarea>
                        <!-- Inserez les mesages d'erreur et succés-->
                        <?= $errors['content'] ? '<p class="text-error">'. $errors['content'] .'</p>' : ""?>
                    </div>
                    <div class="form-control">
                        <input type="submit" value="MODIFIER" class="btn-primary">
                    </div>
                </form>
            </div>
        </section>
</body>