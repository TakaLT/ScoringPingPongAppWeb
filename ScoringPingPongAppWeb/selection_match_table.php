<?php
// On démarre la session 
session_start ();

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

           $req='SELECT * From matchs ';
           $req=$bdd-> query ($req);
           $match = $req ->fetch();

           $id_match=$match['id_matchs'];
        ?>
        <div class="container" align="center">
        <header class="page-header">
            <h3> <?=__Titre_se_t ?> </h3>
        </header> 
        
            
               <div>
                <h3><?=__Table_r ?> </h3>
                <table id="TabTournoi" class="tablesorter table-bordered">
                <thead>
                    <tr> <th> <?=__Id_match ?>  </th> <th>  <?=__Nom_tournoi ?> </th><th>  <?=__Nom_tableau ?>  </th> <th>  <?=__Horaire ?>  </th> <th>  <?=__Table ?> </th><th>  <?=__Comp1 ?>  </th><th>  <?=__Comp2 ?>  </th> <th>  <?=__Act ?>  </th> </tr>
                </thead>
                <tbody>
                <?php 
                            $req='SELECT id_matchs, nom_tournoi, nom_tableau ,horaire_tour,nbre_manche_tournoi, num_table, A.nom_competiteur AS competiteur1, B.nom_competiteur AS competiteur2 FROM matchs Join competiteur A On id_competiteur1 = A.id_competiteur Join competiteur B On id_competiteur2 = B.id_competiteur join tour on matchs.id_tour = tour.id_tour Join tableau on matchs.id_tableau = tableau.id_tableau join tournoi on tableau.id_tournoi=tournoi.id_tournoi where matchs.id_statut=2 or matchs.id_statut=1';
                            $req_rencontre = $bdd -> query ($req);
                            $nb_match= $req_rencontre->rowCount();
                            
                            if ($nb_match >0 ){
                                while ($rencontre=$req_rencontre->fetch())
                                {
                                ?>
                                    <tr> <td> <?=$rencontre['id_matchs']?> </td> <td> <?=$rencontre['nom_tournoi']?> </td><td> <?=$rencontre['nom_tableau']?> </td> <td> <?=$rencontre['horaire_tour']?> </td><td> <?=$rencontre['num_table']?> </td><td> <?=$rencontre['competiteur1']?> </td> <td> <?=$rencontre['competiteur2']?> </td>  <td> <a href="affichage_score_table.php?table=<?=$rencontre['num_table']?>"> <?=__Select ?>  </a></td> </tr>
                                <?php
                                }
                            } else { ?>
                                    <tr> <td colspan="8"> <h2> Aucune partie en attente sur ce tournois</h2></td></tr> 
                            <?php 
                            
                            }
                                $req_rencontre->closeCursor();
                            
                            ?>
                </tbody>
                </table>
            </div>
                   
            <a href="menu.php" ><?=__Retour ?></a>
        </div> 
        <footer>
            
        </footer>
        <script type="text/javascript" src="/<?=$Rep?>jQuery/jquery-1.11.1.js"></script>
        <script type="text/javascript" src="/<?=$Rep?>bootstrap/dist/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="/<?=$Rep?>module_jquery/TableSorter/jquery.tablesorter.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function() 
                { 
                    $("#TabTournoi").tablesorter(); 
                }); 
        </script> 
    </body>
</html>