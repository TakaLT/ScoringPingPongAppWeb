<?php
include_once('lang/lang_conf.php');

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
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="/<?=$Rep?>bootstrap/dist/css/bootstrap.css" rel="stylesheet" type="text/css">
        <link href="/<?=$Rep?>bootstrap/dist/css/bootstrap-theme.css" rel="stylesheet" type="text/css">
        <link href="/<?=$Rep?>CSS/style.css" rel="stylesheet" type="text/css">
        
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        
        <title><?=__Titre_start ?></title>
    </head>
    <body id="body_accueil">
         <?php
        // put your code here
        ?>
        <header>
           
        </header>
        <div class="container" align='center'>
            <div class="row">
                <div id="index" class="col-lg-12">
                <h2><?=__Mes_index ?></h2>
                </div>
                <img src="images/img_accueil.jpg" id="img_accueil">
            
            <form method="post" action="accueil.php">
                <input type="submit" name="start" class="btn btn-lg btn-primary btn-block start" value="<?=__Valide_index ?>">
            </form>
            </div>
        </div>
        <footer>
            
        </footer>
    </body>
</html>
