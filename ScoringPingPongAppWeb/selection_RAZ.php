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
    echo '<title>Selection match</title>';
    echo '</head>';

    echo '<body>';
    echo '<br />';

// On affiche un lien pour fermer notre session
echo '<a href="./logout.php">Accueil</a>';
}
else {
//echo 'Les variables ne sont pas déclarées.';
}?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="/<?=$Rep?>bootstrap/dist/css/bootstrap.css" rel="stylesheet" type="text/css">
        <link href="/<?=$Rep?>bootstrap/dist/css/bootstrap-theme.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="/<?=$Rep?>module_jquery/TableSorter/themes/blue/style.css" type="text/css" id="" media="print, projection, screen" />
        <title></title>
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
        <div class="container" align="center">
        <header class="page-header" align="center">
            <h3> <?=__Titre_RAZ ?> </h3>
        </header> 
            <div class="form-group bg-danger">
                <ul class="nav nav-pills nav-stacked">
    
                <li><a href="#" id="RAZ_base">Remise a zéro de toutes les bases</a></li>
                <li><a href="#" id="RAZ_competiteur">Remise a zéro des la base competiteur </a></li>
                <li><a href="#" id="RAZ_rencontre">Remise a zéro des rencontres </a></li>
                <li><a href="#" id="RAZ_tour">Remise a zéro des tours </a></li>
                <li><a href="#" id="RAZ_tableau">Remise a zéro des tableaux </a></li>
                <li><a href="#" id="RAZ_tournoi">Remise a zéro des tournois </a></li>
                                
            </ul>
                
            </div>
        <footer>
            <a href="menu.php" ><?=__Retour ?></a>
        </footer>
        </div>
        <script type="text/javascript" src="/<?=$Rep?>jQuery/jquery-1.11.1.js"></script>
        <script type="text/javascript" src="/<?=$Rep?>bootstrap/dist/js/bootstrap.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function() 
            {
                $( "#RAZ_base" ).click(function() {
                    var alert= confirm('<?=__Alert_RAZ_base?>');
                    if(alert == true)
                        {
                          document.location.href="RAZ_base.php?action=RAZ";
                            
                        }
                                            
                        });
                        $( "#RAZ_competiteur" ).click(function() {
                    var alert= confirm('<?=__Alert_RAZ_competiteur?>');
                    if(alert == true)
                        {
                          document.location.href="RAZ_competiteur.php?action=RAZ";
                            
                        }
                        
                        });
                        $( "#RAZ_rencontre" ).click(function() {
                    var alert= confirm('<?=__Alert_RAZ_rencontre?>');
                    if(alert == true)
                        {
                          document.location.href="RAZ_rencontre.php?action=RAZ";
                                            
                        }
                        
                        });
                        $( "#RAZ_tour" ).click(function() {
                    var alert= confirm('<?=__Alert_RAZ_tour?>');
                    if(alert == true)
                        {
                          document.location.href="RAZ_tour.php?action=RAZ";
                            
                        }
                                               
                        });
                        $( "#RAZ_tableau" ).click(function() {
                    var alert= confirm('<?=__Alert_RAZ_tableau?>');
                    if(alert == true)
                        {
                          document.location.href="RAZ_tableau.php?action=RAZ";
                            
                        }
                                               
                        });
                        $( "#RAZ_tournoi" ).click(function() {
                    var alert= confirm('<?=__Alert_RAZ_tournoi?>');
                    if(alert == true)
                        {
                          document.location.href="RAZ_tournoi.php?action=RAZ";
                            
                        }
                                                
                        });
                        
           
            });
        
        </script> 
        
    </body>
</html>
