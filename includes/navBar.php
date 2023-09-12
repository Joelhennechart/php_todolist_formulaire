<header>    
     <section class="todolist_navBar">
    <p>
        <h2 class="todolist_bloc_title">Ma todolist</h2>
    </p>
    <!-- logo clickable qui retourne vers l'accueil connecté -->
    <a href="connected.php"><img alt="mon logo" src="./media/image/logo.png"></a>
      <!-- liens de redirection (celon si connecté ou non)-->
    <?php
        //si pas de userID dans la session
        if(isset($_SESSION['userID'])){
            echo('<a href="index.php">deconnexion</a>
            <a href="all_article.php">liste des articles</a>
            <a href="new_article.php">Ajouter un nouvel article</a>');
            }
        else {
            echo('<a href="create_account.php">Créer un compte</a>');
        }?>
   <!-- Les liens de redirections : un lien pour chaque élément du CRUD mis en place -->
   
    
</section>