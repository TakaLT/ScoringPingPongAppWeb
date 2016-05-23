<?php
//On inclut le fichiers conf 
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
        
        <title><?=__Titre_ac?></title>
    </head>
    <body>
        <?php
        
        ?>
        <div class="container" align='center'>
        <header class="page-header">
            <h2><?=__Titre_ac?></h2>
        </header>
            <div class="row">
            <div class="col-lg-2 col-lg-offset-5">
        
            <form method="POST" action="login.php">
                <div class="form-group">
                    <label for="utilisateur"><?=__Utilisateur?> :</label><br/>
                    <input type="text" name="utilisateur" id="utilisateur" class="form-control" />
                </div>
                <div class="form-group">
                    <label for="password"><?=__Paswword?> :</label><br/>
                    <input type="password" name="password" id="password" class="form-control"/>
                </div>
                <div class="form-group">
                    <input type="reset" name="reset" class="btn btn-default" value="<?=__Annuler?>"/> <input type="submit" name="valide" class="btn btn-default" value="<?=__Valider?>"/>
                </div>
            </form>   
            </div>
            </div>
            <footer>
                
            </footer>
        </div>
        <script type="text/javascript" src="/<?=$Rep?>jQuery/jquery-1.11.1.js"></script>
        <script type="text/javascript" src="/<?=$Rep?>bootstrap/dist/js/bootstrap.min.js"></script>
        <footer>
            
        </footer>
    </body>
</html>
