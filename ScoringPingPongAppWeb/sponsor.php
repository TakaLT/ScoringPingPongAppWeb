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
    echo '<title>Sponsor</title>';
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
        <link rel="stylesheet" href="/<?=$Rep?>module_jquery/TableSorter/themes/blue/style.css" type="text/css" id="" media="print, projection, screen" />
        
        
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
        
      
        if (isset($_POST['valide_sponsor']))
        {
            // connexion a la base
            $req='SELECT * FROM sponsor';
            $req_verif=$bdd->query($req);
            $nbreligne=$req_verif->rowCount();
            
            if ($nbreligne <1)                 
            {            
            // On redupère le chemin du script, les images sont stockée dans le sous rep images...
            $Dir=realpath(dirname(__FILE__));
        
        
            if ($_FILES['fichier']['tmp_name']!='') 
            {
                // savoir si c'est une image, on verifir qu'il a une taille en pixel
               $size = getimagesize( $_FILES['fichier']['tmp_name'] );
            
            // si c'est une image, on traite
            if ($size!==FALSE) 
                {
                // grain de sable pour nom de fichier unique
                    $Time=microtime();
                    $NomImg=urlencode($Time.'-'.$_FILES['fichier']['name']);

                // On deplace le fichier avec le nom
                    $Deplace = move_uploaded_file ($_FILES['fichier']['tmp_name'],$Dir.'/sponsor/'.$NomImg);
                    //echo 'le fichier est deplacer '. $Deplace;

                // si deplacement OK
                if ($Deplace)
                    {
                       // on insert info dans la base
                    $req='INSERT INTO sponsor (nom_sponsor) VALUES (:nom)';
                    $req_in=$bdd->prepare($req);
                    $req_in ->execute(array('nom'=>$NomImg));
                    
                     //reccuperation de id du dernier sponsor
                    $id_sponsor = $bdd -> lastInsertId();
                    
                    //reccuperation du dernier id_tournoi
                    $req_id='select id_tournoi FROM tournoi ORDER BY id_tournoi DESC LIMIT 1 ';
                    $req_id = $bdd ->query($req_id);
                    $id_tournoi=$req_id->fetch();
                    $id_tournoi=$id_tournoi['id_tournoi'];
                    //echo $id_tournoi;
                    
                    $req_financement='INSERT INTO financement (id_sponsor, id_tournoi) VALUES (:sponsor, :tournoi)';
                    $req_insert_financement= $bdd ->prepare($req_financement);
                    $req_insert_financement->execute (array('sponsor'=>$id_sponsor, 'tournoi'=>$id_tournoi));

                 
                    }
                // SInon, on supprime fichier
                else 
                    {
                    echo '<h3>'.__mes22.'</h3>';
                    unlink ( $_FILES['fichier']['tmp_name'] );
                    }
                }
        // si pas image, on supprime
            else 
                {
                echo '<h3>'.__mes23.'</h3>';
                unlink ( $_FILES['fichier']['tmp_name'] );
                }
            }
            }
        else 
            {
                echo '<h3>'.__mes21.'</h3>';
            }
        
        }
       
        ?>
        <div class="container" align="center">
        <header class="page-header">
            <h2><?=__Titre_sponsor ?></h2>
        </header>
        <div class="row">
            <div class="col-lg-6 col-lg-offset-3">
            <form action="#" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="fichier"><?=__Nom_f ?> :</label><br/>
                    <input type="hidden" name="max_file_size" value="1048576" class="form-control" />
                    <input type='file' name='fichier' id="fichier" class="form-control"/>
                </div>
                <div class="form-group">
                    <input type="submit" name="valide_sponsor" class="btn btn-default" Value='<?=__Upload ?>'/>
                </div>
            </form>
             <a href="menu.php" ><?=__Retour ?></a>
             </div>
        </div>
        
             <div class="form-group" align='center'>
                 <h3><?=__Liste_Sponsor ?></h3>
                 <table id="table_sponsor" class=" tablesorter table-bordered">
                    <thead>
                         <tr><th><?=__Image ?></th><th> <?=__Act ?> </th></tr>
                    </thead>
                    <tbody>                       
                            <?php
                            $req_sp='SELECT * FROM sponsor';
                            $req_sp = $bdd -> query ($req_sp);
                            while ($data_sponsor=$req_sp->fetch())       

                               {

                            ?>
                            <tr>
                                <td><img src='sponsor/<?=$data_sponsor['nom_sponsor']?>' height="100"></td>
                                
                                <td> <a href="supprime_sponsor.php?action=supp&id_img=<?=$data_sponsor['id_sponsor']?>"> <?=__Sup_i ?> </a> </td>
                            </tr>
                            <?php
                                    }
                            ?>
                    </tbody>
                </table>
                
            </div>
            
        
        <footer>
            
        </footer>
             </div>
        <script type="text/javascript" src="/<?=$Rep?>jQuery/jquery-1.11.1.js"></script>
        <script type="text/javascript" src="/<?=$Rep?>bootstrap/dist/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="/<?=$Rep?>module_jquery/TableSorter/jquery.tablesorter.min.js"></script>
        <script type="text/javascript">
        $(document).ready(function() 
                { 
                    $("#table_sponsor").tablesorter();
                    
                }); 
        </script> 
    </body>
</html>
