<?php
// On démarre la session 
session_start ();
include_once('lang/lang_conf.php');
// On récupère nos variables de session
if (isset($_SESSION['utilisateur']) && ($_SESSION['utilisateur'] != ''))
    {

    // On teste pour voir si nos variables ont bien été enregistrées
    echo '<html>';
    echo '<head>';
    echo '<title>Menu</title>';
    echo '</head>';

    echo '<body>';
       echo '<br />';

// On affiche un lien pour fermer notre session
echo '<a href="./logout.php">Accueil</a>';
}
else {
//echo 'Les variables ne sont pas déclarées.';
}
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link href="/<?=$Rep?>bootstrap/dist/css/bootstrap.css" rel="stylesheet" type="text/css">
        <link href="/<?=$Rep?>bootstrap/dist/css/bootstrap-theme.css" rel="stylesheet" type="text/css">
        <link href="/<?=$Rep?>CSS/style.css" rel="stylesheet" type="text/css">
        
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        
    </head>
    <body>
        <?php
        // put your code here
        ?>
        <header class="page-header">
            <h2><?=__Titre_menu ?></h2>
        </header>
        <div align='center' class="container">
            <h4> <?=__Lien_admin ?> :</h4><br/>
            <ul class="nav nav-pills nav-stacked">
                <li><a href='tournoi.php'><?=__Tournoi ?></a></li>
                <li><a href="tableau.php"><?=__Tableau ?></a></li>
                <li><a href='tour.php'><?=__Tour ?></a></li>
                <li><a href="competiteur.php"><?=__Competiteur ?></a></li>
                <li><a href="rencontre.php"><?=__Rencontre ?></a></li>
                <li><a href='sponsor.php'><?=__Sponsor ?></a></li>
                <li><a href='pub.php'><?=__Pub ?></a></li>
                 <li><a href="configuration.php"><?=__Theme?></a></li>              
            </ul>            
            <h4> <?=__Lien ?> :</h4><br/>
            <ul class="nav nav-pills nav-stacked">
                <li><a href="selection_match_admin.php"><?=__Match ?></a></li>
                <li> <a href="affichage_score_all_table.php"><?=__aff_all ?></a></li>
                <li> <a href="selection_match_table.php"><?=__aff_table ?> </a></li>
                <li><a href="affichage_pub.php"><?=__aff_pub ?> </a></li>
            </ul>
            <h4><?=__Lien_RAZ ?> :</h4><br/>
            <ul class="nav nav-pills nav-stacked">
                    <li> <a href="selection_RAZ.php"><?=__Select_RAZ ?></a></li>                
            </ul>
        
        </div>
        <footer>
            
        </footer>
        <script type="text/javascript" src="/<?=$Rep?>jQuery/jquery-1.11.1.js"></script>
        <script src="/<?=$Rep?>bootstrap/dist/js/bootstrap.min.js"></script>
    </body>
</html>
