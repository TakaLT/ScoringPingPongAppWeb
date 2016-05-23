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
    echo '<title>Parametre</title>';
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
        <link href="/<?=$Rep?>module_jquery/bootstrap-colorpicker-master/dist/css/bootstrap-colorpicker.min.css" rel="stylesheet" type="text/css">
        
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        
    </head>
    <body>
        <?php
        include 'connexion.php';
        
        if ( ( $_GET['action']=='modif' ) && ( $_GET['id_parametre']!='' ) ) 
          {
            //alimentation des champs 
            $req="SELECT  * FROM parametre join configuration on parametre.id_parametre=configuration.id_parametre WHERE parametre.id_parametre='".$_GET['id_parametre']."'";
            $req=$bdd-> query ($req);
            $parametre = $req ->fetch();
            
          }
        
        
        if (isset($_POST['modif_parametre']))
        {
            if ($_GET['id_parametre']!=1 )
                {
                    //recuperation des variable
                    $couleurf=  htmlspecialchars($_POST['couleur_fond']);
                    $couleurt=  htmlspecialchars($_POST['couleur_text']);
                    $style=  htmlspecialchars(($_POST['style']));
            
                    //Mise a jour  
                    $req='UPDATE configuration SET nom_configuration= :nom   WHERE id_parametre = :id_parametre ';
                    $req_modif= $bdd->prepare($req);
                    $req_modif->execute (array('nom'=>$_POST['nom_theme'], 'id_parametre'=>$_GET['id_parametre']));
            
                    $req='UPDATE parametre SET couleur_fond= :couleur_f , couleur_text= :couleur_t , taille_text= :taille , gras= :gras , style_text= :style  WHERE id_parametre = :id_parametre ';
                    $req_modif= $bdd->prepare($req);
                    $req_modif->execute (array('couleur_f'=>$couleurf, 'couleur_t'=>$couleurt, 'taille'=>$_POST['taille'], 'gras'=>$_POST['gras'], 'style'=>$style, 'id_parametre'=>$_GET['id_parametre']));
            
                }
            else 
                {
                    echo '<h3>'.__mes5.'</h3>';
                }
           
        }
        ?>
        <div class="container" align='center'>
        <header class="page-header">
            <h3><?=__Titre_modif_parametre ?></h3>
        </header>
         <div class="row">
            <div class="col-lg-2 col-lg-offset-5">
            <form method='POST' action='#'>
                <div class="form-group">
                    <label for="nom_theme_mod"><?=__Nom_p ?> :</label><br/>
                    <input type="text" name="nom_theme" id="nom_theme_mod" class="form-control" value="<?php echo $parametre['nom_configuration'] ?>"/>
                </div>
                <div class="form-group">
                    <label for="couleur_fond_mod"><?=__Cou_f ?> :</label><br/>
                    <input type="text" name="couleur_fond" id="couleur_fond_mod" class="colorpicker form-control" value="<?php echo $parametre['couleur_fond'] ?>"/>
                </div>
                <div class="form-group">
                    <label for="couleur_text_mod"><?=__Cou_t ?> :</label><br/>
                    <input type="text" name="couleur_text" id="couleur_fond_mod" class="colorpicker form-control" value="<?php echo $parametre['couleur_text'] ?>"/>
                </div>
                <div class="form-group">
                    <label for="taille_mod"><?=__Taille ?> :</label><br/>
                    <input type="text" name="taille" id="taille_mod" class="form-control" value="<?php echo $parametre['taille_text'] ?>"/>
                </div>
                <div class="form-group">
                    <label for="gras_mod"><?=__Gras ?> :</label><br/>
                    <input type="text" name="gras" id="gras_mod" class="form-control" value="<?php echo $parametre['gras'] ?>" placeholder="<?=__Com_g ?>"/>
                </div>
                <div class="form-group">
                    <label for="style_mod"><?=__Forme ?> :</label><br/>
                    <input type="text" name="style" id="style_mod" class="form-control" value="<?php echo $parametre['style_text'] ?>"/>
                </div>
                <div class="form-group">
                    <input type="reset" name="reset" class="btn btn-default" value="<?=__Reset ?> "/> <input type="submit" name="modif_parametre" class="btn btn-default" value="<?=__Modifier ?> "/>
                </div>
            </form>
                <a href="menu.php" ><?=__Retour ?></a>
                <a href="parametre.php" ><?=__Retour_parametre ?></a>
                </div>
        </div>
            <div class="form-group">
                <h3> <?=__Table_t ?> </h3>
                <table id="TabTournoi" class="tablesorter table-bordered">
                <thead>
                    <tr> <th>  <?=__Id_parametre ?>  </th> <th>  <?=__Nom_p ?> </th><th>  <?=__Cou_f ?>  </th><th>  <?=__Cou_t ?> </th> <th>  <?=__Taille ?>  </th> <th> <?=__Gras ?></th><th>   <?=__Forme ?>   </th><th>  <?=__Act ?>  </th> </tr>
                </thead>
                <tbody>
                <?php 
                        $req='SELECT parametre.id_parametre, nom_configuration, couleur_fond, couleur_text, taille_text, gras, style_text FROM parametre join configuration on parametre.id_parametre=configuration.id_parametre';
                        $req_para = $bdd -> query ($req);
                        while ($para=$req_para->fetch())
                            {
                        ?>
                    <tr> <td> <?=$para['id_parametre']?> </td> <td> <?=$para['nom_configuration']?> </td><td> <?=$para['couleur_fond']?> </td> <td> <?=$para['couleur_text']?> </td> <td> <?=$para['taille_text']?> </td><td> <?=$para['gras']?> </td><td> <?=$para['style_text']?> </td> <td> <a href="modification_parametre.php?action=modif&id_parametre=<?=$para['id_parametre']?>"> modification </a>/ <a href="supprime_parametre.php?action=supp&id_parametre=<?=$para['id_parametre']?>">supprimer</a></td> </tr>
                        <?php
                        }
                        $req_para->closeCursor();
                        ?>
                </tbody>
            
                </table>
            </div>
        
        <footer>
            
        </footer>
        </div>
        <script type="text/javascript" src="/<?=$Rep?>jQuery/jquery-1.11.1.js"></script>
        <script type="text/javascript" src="/<?=$Rep?>module_jquery/TableSorter/jquery.tablesorter.min.js"></script>
        <script src="/<?=$Rep?>bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="/<?=$Rep?>jQuery/jquery-ui-1.11.0/jquery-ui.js"></script>
         <script src="module_jquery/bootstrap-colorpicker-master/dist/js/bootstrap-colorpicker.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function() 
                { 
                    $("#TabTournoi").tablesorter(); 
                    
                     $('.colorpicker').colorpicker();
                }); 
        </script> 
    </body>
</html>
