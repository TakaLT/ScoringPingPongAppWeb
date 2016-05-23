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
}
?><!DOCTYPE html>
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
        ?>
        <div class="container" align="center">
        <header class="page-header" align="center">
            <h3> <?=__Titre_se ?> </h3>
        </header> 
        
            <div class="form-group">
                <h3> <?=__Table_sel_en_cour ?> </h3>
                <table id="Tabselect1" class="tablesorter table-bordered">
                <thead>
                    <tr> <th> <?=__Id_match ?>  </th> <th>  <?=__Nom_tournoi ?> </th><th>  <?=__Nom_tableau ?>  </th> <th>  <?=__Horaire ?>  </th> <th>  <?=__Table ?> </th><th>  <?=__Comp1 ?>  </th><th>  <?=__Comp2 ?>  </th> <th>  <?=__Act ?>  </th> </tr>
                </thead>
                <tbody>
                <?php 
                            $req='SELECT id_matchs, nom_tournoi, nom_tableau ,horaire_tour,nbre_manche_tournoi, num_table, A.nom_competiteur AS competiteur1, B.nom_competiteur AS competiteur2 FROM matchs Join competiteur A On id_competiteur1 = A.id_competiteur Join competiteur B On id_competiteur2 = B.id_competiteur join tour on matchs.id_tour = tour.id_tour Join tableau on matchs.id_tableau = tableau.id_tableau join tournoi on tableau.id_tournoi=tournoi.id_tournoi where id_statut = 1 ORDER by horaire_tour, num_table';
                            $req_rencontre = $bdd -> query ($req);
                            while ($rencontre=$req_rencontre->fetch())
                                {
                            ?>
                    <tr> <td> <?=$rencontre['id_matchs']?> </td> <td> <?=$rencontre['nom_tournoi']?> </td><td> <?=$rencontre['nom_tableau']?> </td> <td> <?=$rencontre['horaire_tour']?> </td><td> <?=$rencontre['num_table']?> </td><td> <?=$rencontre['competiteur1']?> </td> <td> <?=$rencontre['competiteur2']?> </td>  <td> <a href="match.php?id_match=<?=$rencontre['id_matchs']?>&manche=<?=$rencontre['nbre_manche_tournoi']?>&j1=<?=$rencontre['competiteur1']?>&j2=<?=$rencontre['competiteur2']?>"> <?=__Select ?>  </a></td> </tr>
                            <?php
                            }
                            $req_rencontre->closeCursor();
                            ?>
                </tbody>
                </table>
            </div>
             <div class="form-group">
                <h3> <?=__Table_sel_en_Att ?></h3>
                <table id="Tabselect2" class="tablesorter table-bordered">
                <thead>
                    <tr> <th> <?=__Id_match ?>  </th> <th>  <?=__Nom_tournoi ?> </th><th>  <?=__Nom_tableau ?>  </th> <th>  <?=__Horaire ?>  </th> <th>  <?=__Table ?> </th><th>  <?=__Comp1 ?>  </th><th>  <?=__Comp2 ?>  </th> <th>  <?=__Act ?>  </th> </tr>
                </thead>
                <tbody>
                <?php 
                            $req='SELECT id_matchs, nom_tournoi, nom_tableau ,horaire_tour,nbre_manche_tournoi, num_table, A.nom_competiteur AS competiteur1, B.nom_competiteur AS competiteur2 FROM matchs Join competiteur A On id_competiteur1 = A.id_competiteur Join competiteur B On id_competiteur2 = B.id_competiteur join tour on matchs.id_tour = tour.id_tour Join tableau on matchs.id_tableau = tableau.id_tableau join tournoi on tableau.id_tournoi=tournoi.id_tournoi where id_statut = 2 ORDER by horaire_tour, num_table';
                            $req_rencontre = $bdd -> query ($req);
                            while ($rencontre=$req_rencontre->fetch())
                                {
                            ?>
                    <tr> <td> <?=$rencontre['id_matchs']?> </td> <td> <?=$rencontre['nom_tournoi']?> </td><td> <?=$rencontre['nom_tableau']?> </td> <td> <?=$rencontre['horaire_tour']?> </td><td> <?=$rencontre['num_table']?> </td><td> <?=$rencontre['competiteur1']?> </td> <td> <?=$rencontre['competiteur2']?> </td>  <td> <a href="match.php?id_match=<?=$rencontre['id_matchs']?>&manche=<?=$rencontre['nbre_manche_tournoi']?>&j1=<?=$rencontre['competiteur1']?>&j2=<?=$rencontre['competiteur2']?>"> <?=__Select ?>  </a></td> </tr>
                            <?php
                            }
                            $req_rencontre->closeCursor();
                            ?>
                </tbody>
                </table>
            </div>
                
                   
            <a href="accueil.php" ><?=__Dec?></a>
         
        <footer>
            
        </footer>
        </div>
        <script type="text/javascript" src="/<?=$Rep?>jQuery/jquery-1.11.1.js"></script>
        <script type="text/javascript" src="/<?=$Rep?>bootstrap/dist/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="/<?=$Rep?>module_jquery/TableSorter/jquery.tablesorter.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function() 
                { 
                    $("#Tabselect1").tablesorter();
                    $("#Tabselect2").tablesorter();
                    
                   
                }); 
        </script> 
    </body>
</html>
