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
    // On a déja $userID pour l'id de l'auteur
    setlocale(LC_TIME, ['fr', 'fra','fr_FR']);
    $creation_date = date('Y-m-d'); //creation de date qui ne peut pas changer a l'americaine
    //et qui par default est le jour de la création de l'article

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
            $rqt = "INSERT INTO article VALUES (DEFAULT, :title, :content, :author, :creation_date)";
            $db_statement = $db_connexion->prepare($rqt);
            $db_statement->execute(
                array(
                    ':title' =>$title,
                    ':content'=>$content,
                    ':author'=>$userID,
                    ':creation_date'=>$creation_date)
            );
            $message = "<span class = 'message'> Votre article a bien été crée !</span>";}
             }       
        else{
        $message = "<span class = 'message'> Veuillez renseigner tous les champs ! </span>";
        }

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
    require_once('./includes/navBar.php')
    ?>  
    <!-- Ma navBar todolist est importée -->
    <?php 
    require_once('./includes/todolist_navBar.php');
    ?>    

<section class="container">
    <div class="form-container">
        <!-- Formulaire pour ajouter un nouvel article -->
        <h1>Créer un  nouvel article !</h1>
        
        
        <form action="#" method="post">
            <div class="form-control">
            <input type="text" name="title" id="title" placeholder="Votre titre ici ...">
            <!-- TODO : Inserez les mesages d'erreur et succés-->
            <?= $errors['title'] ? '<p class="text-error">'. $errors['content'] .'</p>' : ""?>
        </div>
            
            <div class="form-control">
                <textarea rows="5" name="content" id="content" placeholder="votre contenu détaillé ici..."></textarea>
                <!-- TODO : Inserez les mesages d'erreur et succés-->
                <?= $errors['content'] ? '<p class="text-error">'. $errors['content'] .'</p>' : ""?>
            </div>
            <div class="form-control">
                <input type="submit" value="VALIDER" class="btn-primary">
            </div>
        </form>
    </div>
</section>
</body>
</html>