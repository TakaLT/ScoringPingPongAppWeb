<?php
// On démarre la session 
session_start ();

// inclusion du fichier connect et conf 
include_once('lang/lang_conf.php');

// On récupère nos variables de session
if (isset($_SESSION['utilisateur']))
    {

    // On teste pour voir si nos variables ont bien été enregistrées
    echo '<html>';
    echo '<head>';
    echo '<title>Configuration</title>';
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
        <link rel="stylesheet" href="/<?=$Rep?>module_jquery/TableSorter/themes/blue/style.css" type="text/css" id="" media="print, projection, screen" />
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
        // connexion a la base
        include 'connexion.php';
        
        ?>
        <div class="container" align="center">
        <header class="page-header">
            <h2><?=__Titre_configuration ?></h2>
        </header>
        
            <div class="form-group">
            <h3> <?=__Table_co ?> </h3>
                <table id="TabTournoi" class="tablesorter table-bordered">
                    <thead>
                        <tr> <th> <?=__Id_co ?> </th> <th>  <?=__Nom_p ?> </th><th>  <?=__Cou_f ?>  </th><th>  <?=__Cou_t ?>  </th> <th>  <?=__Taille ?>  </th> <th>  <?=__Gras ?> </th><th>  <?=__Forme ?>  </th><th>  <?=__Act ?>  </th> </tr>
                    </thead>
                    <tbody>
                    <?php 
                                $req_t='SELECT * FROM configuration join parametre on configuration.id_parametre = parametre.id_parametre ';
                                $req_t = $bdd -> query ($req_t);
                                while ($configuration=$req_t->fetch()) 
                                    {
                                ?>
                        <tr> <td> <?=$configuration['id_configuration']?> </td> <td> <?=$configuration['nom_configuration']?> </td><td> <?=$configuration['couleur_fond']?> </td> <td> <?=$configuration['couleur_text']?> </td> <td> <?=$configuration['taille_text']?> </td><td> <?=$configuration['gras']?> </td><td> <?=$configuration['style_text']?> </td> <td> <a href="modification_configuration.php?action=modif&id_configuration=<?=$configuration['id_configuration']?>"> modification </a>/ <a href="supprime_configuration.php?action=supp&id_configuration=<?=$configuration['id_configuration']?>">supprimer</a></td> </tr>
                                <?php
                                }
                                $req_t->closeCursor();
                                ?>
                    </tbody>

                </table> 
            </div>
            <div class="form-group">
            <a href='parametre.php'><?=__Ajout_t ?></a></br>
            <a href='menu.php' ><?=__Retour ?></a><br/>
            </div>
        
        
        <footer>
            
        </footer> 
        </div>
        <script type="text/javascript" src="/<?=$Rep?>jQuery/jquery-1.11.1.js"></script>
        <script type="text/javascript" src="/<?=$Rep?>module_jquery/TableSorter/jquery.tablesorter.min.js"></script>
        <script src="/<?=$Rep?>bootstrap/dist/js/bootstrap.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function() 
                { 
                    $("#TabTournoi").tablesorter(); 
                }); 
        </script> 
      
    </body>
</html>
