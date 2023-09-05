<header>    
    <!-- logo cliccable qui retourne vers l'accueil connecté -->
    <a href="connected.php"><img alt="mon logo" src="./media/image/logo.png"></a>
    <!-- liens de redirection (celon si connecté ou non)-->
    <?php
        //si pas de userID dans la session
        if(!isset($_SESSION['userID'])){
            echo('<a href="index.php">Se connecter</a>
        <a href="create_account.php">Créer un compte</a>');
        }

        // TODO : Si userId présent dans la session //
    ?>
</header>