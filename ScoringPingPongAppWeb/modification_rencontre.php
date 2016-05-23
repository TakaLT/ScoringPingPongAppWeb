<?php
// On démarre la session 
session_start ();

include_once('lang/lang_conf.php');

// On récupère nos variables de session
if (isset($_SESSION['utilisateur']))
    {

    // On teste pour voir si nos variables ont bien été enregistrées
    echo '<html>';
    echo '<head>';
    echo '<title>Rencontre</title>';
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
        <link rel="stylesheet" href="/<?=$Rep?>module_jquery/TableSorter/addons/pager/jquery.tablesorter.pager.css" type="text/css" id="" media="print, projection, screen" />
        
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
        // connexion bdd
        include 'connexion.php';
        
        if ( ( $_GET['action']=='modif' ) && ( $_GET['id_matchs']!='' ) ) 
          {
            //echo 'je suis la';
            //alimentation des champs 
            $req="SELECT id_matchs, matchs.id_tour, matchs.id_tableau, nom_tournoi, nom_tableau ,horaire_tour, num_table, A.id_competiteur AS id_competiteur1, A.nom_competiteur AS competiteur1,B.id_competiteur AS id_competiteur2, B.nom_competiteur AS competiteur2, statut.id_statut FROM matchs Join competiteur A On id_competiteur1 = A.id_competiteur Join competiteur B On id_competiteur2 = B.id_competiteur join tour on matchs.id_tour = tour.id_tour Join tableau on matchs.id_tableau = tableau.id_tableau join tournoi on tableau.id_tournoi=tournoi.id_tournoi join statut on statut.id_statut= matchs.id_statut  WHERE id_matchs='".$_GET['id_matchs']."'";
            $req=$bdd-> query ($req);
            $match = $req ->fetch();
            
            //echo $match['id_tableau'];
            
          }
        
        if (isset($_POST['modif_match'])) 
            {

            
            $req_id="SELECT id_competiteur FROM competiteur WHERE num_dossard='".$_POST['joueur1']."' OR nom_competiteur='".$_POST['joueur1']."' ";
            $req_id=$bdd -> query ($req_id);
            $id_joueur1=$req_id->fetch();
            $id_joueur1=$id_joueur1['id_competiteur'];


            //id du joueur2
            $req_id="SELECT id_competiteur FROM competiteur WHERE num_dossard='".$_POST['joueur2']."'OR nom_competiteur='".$_POST['joueur2']."'";
            $req_id=$bdd -> query ($req_id);
            $id_joueur2=$req_id->fetch();
            $id_joueur2=$id_joueur2['id_competiteur'];


            if( $id_joueur1 != $id_joueur2)
                {
                    //control si renncontre deja rentrer
                    $req="SELECT * FROM matchs WHERE num_table = '".$_POST['num_table']."'  AND id_tour ='".$_POST['tour']."' AND id_tableau='".$_POST['tableau']."' AND id_statut = 4 AND id_competiteur1 = '".$id_joueur1."' AND id_competiteur2= '".$id_joueur2."'  ";
                    $req_verif=$bdd->query($req);
                    $nbreligne=$req_verif->rowCount();

                    
                                   
                                        $req2='UPDATE participation SET id_tableau= :tableau, id_competiteur1= :comp1, id_competiteur2= :comp2 WHERE id_tableau = :id_tableau AND id_competiteur1 = :id_comp1 AND id_competiteur2 = :id_comp2 ';
                                        $req_modif2= $bdd->prepare($req2);
                                        $req_modif2->execute (array('tableau'=>$_POST['tableau'], 'comp1'=>$id_joueur1, 'comp2'=>$id_joueur2, 'id_tableau'=>$match['id_tableau'], 'id_comp1'=>$match['id_competiteur1'], 'id_comp2'=>$match['id_competiteur2']));
                                        
                                    
                                        $req='UPDATE matchs SET num_table= :table, id_tour= :tour, id_statut=:statut , id_tableau= :tableau, id_competiteur1= :comp1, id_competiteur2= :comp2 WHERE id_matchs = :id_match ';
                                        $req_modif= $bdd->prepare($req);
                                        $req_modif->execute (array('table'=>$_POST['num_table'], 'tour'=>$_POST['tour'],'statut'=>$_POST['statut'], 'tableau'=>$_POST['tableau'], 'comp1'=>$id_joueur1, 'comp2'=>$id_joueur2, 'id_match'=>$_GET['id_matchs']));

                                                                          
                }
            else
                {
                    echo '<h3>'.__mes6.'</h3>';
                }
            }
        ?>
        <div class="container" align="center">
        <header class="page-header">
            <h3><?=__Titre_modif_match ?> </h3>
        </header>
        <div class="row">
            <div class="col-lg-2 col-lg-offset-5">
            <form method="POST" action="#">
                <div class="form-group">
                    <label for="tableau_mod"><?=__Nom_tableau ?> :</label><br/>
                    <select name="tableau" id="tableau_mod" class="form-control">
                        <?php
                        $id_tableau=$match['id_tableau'];
                        
                        
                        
                        $req='SELECT * FROM tableau join tournoi on tableau.id_tournoi=tournoi.id_tournoi';
                        $req_tableau = $bdd -> query ($req);
                        while ($data_tableau=$req_tableau->fetch())
                            {
                        if    ($data_tableau['id_tableau']== $id_tableau)
                        {
                            echo '<option value="'.$data_tableau['id_tableau'].'"selected="selected">'.$data_tableau['nom_tableau'].' - '.$data_tableau['nom_tournoi'].'</option>';
                            
                        }
                         else 
                             {
                              echo '<option value="'.$data_tableau['id_tableau'].'">'.$data_tableau['nom_tableau'].' - '.$data_tableau['nom_tournoi'].'</option>';
                             }
                        
                        }
                        $req_tableau->closeCursor();
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="tour_mod"><?=__Horaire ?> :</label><br/>
                    <select name="tour" id="tour_mod" class="form-control">
                        <?php
                        $id_tour=$match['id_tour'];
                       
                        
                        $req='SELECT * FROM tour ';
                        $req_tour = $bdd -> query ($req);
                        while ($data_tour=$req_tour->fetch())
                            {
                        if ($data_tour['id_tour']== $id_tour)
                        {
                              echo '<option value="'.$data_tour['id_tour'].'"selected="selected">'.$data_tour['horaire_tour'].' - Tour '.$data_tour['num_tour'].'</option>';
                                   
                        }
                         else 
                             {
                              echo '<option value="'.$data_tour['id_tour'].'">'.$data_tour['horaire_tour'].' - Tour '.$data_tour['num_tour'].'</option>';
                             }
                                               
                        }
                        $req_tour->closeCursor();
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="statut_mod"><?=__Statut ?> :</label><br/>
                    <select name="statut" id="statut_mod" class="form-control">
                        <?php
                        $id_statut=$match['id_statut'];
                       
                        
                        $req='SELECT * FROM statut ';
                        $req_statut = $bdd -> query ($req);
                        while ($data_statut=$req_statut->fetch())
                            {
                        if ($data_statut['id_statut']== $id_statut)
                        {
                              echo '<option value="'.$data_statut['id_statut'].'"selected="selected">'.$data_statut['type_statut'].'</option>';
                                   
                        }
                         else 
                             {
                              echo '<option value="'.$data_statut['id_statut'].'">'.$data_statut['type_statut'].'</option>';
                             }
                                               
                        }
                        $req_statut->closeCursor();
                        ?>
                    </select>
                </div>
                      
                <div class="form-group">
                    <label for="num_table_mod"><?=__Table ?> :</label><br/>
                    <input type="text" name="num_table" id="num_table_mod" class="form-control" value="<?php echo $match['num_table'] ?>"/>
                </div>
                <div class="form-group">
                    <label for="listej1"><?=__Sel_Comp1 ?> :</label><br/>
                    <input type="text" name="joueur1" list="joueur1" id="listej1" class="form-control" required="true" value="<?php echo $match['competiteur1'] ?>"/>
                        <datalist id="joueur1">
                            <?php

                           $req='SELECT * FROM competiteur order by num_dossard asc';
                           $req_compt = $bdd -> query ($req);
                           while ($data_compt=$req_compt->fetch())
                               {
                           ?>
                           <option value="<?php echo $data_compt['nom_competiteur'];?> "><?php echo $data_compt['nom_competiteur']; echo ' - '.$data_compt['num_dossard']; ?> </option>
                           <?php
                           }

                           $req_compt->closeCursor();
                           ?>
                        </datalist>
                </div>
                <div class="form-group">
                    <label for="listej2"><?=__Sel_Comp2 ?> :</label><br/>
                    <input type="text" name="joueur2" list="joueur2" id="listej2" class="form-control" required="true" value="<?php echo $match['competiteur2'] ?>"/><br/>
                        <datalist id="joueur2">
                            < <?php

                            $req='SELECT * FROM competiteur order by num_dossard asc';
                            $req_compt = $bdd -> query ($req);
                            while ($data_compt=$req_compt->fetch())
                                {
                            ?>
                            <option value="<?php echo $data_compt['nom_competiteur'];?> "><?php echo $data_compt['nom_competiteur']; echo ' - '.$data_compt['num_dossard']; ?> </option>
                            <?php
                            }
                            $req_compt->closeCursor();
                            ?>
                        </datalist>
                </div>
                <div class="form-group">
                    <input type="reset" name="reset" class="btn btn-default" value="<?=__Reset ?> "/> <input type="submit" name="modif_match" class="btn btn-default"  value="<?=__Modifier ?> "/>
                </div>
            </form>
                <a href="menu.php" ><?=__Retour ?></a>
                <a href="rencontre.php" ><?=__Retour_rencontre ?></a>
                </div>    
            </div>
        <div>
                    
            <h3> <?=__Table_r ?> </h3>
            <table id="TabRencontre" class="tablesorter table-bordered">
                <thead>
                    <tr> <th> <?=__Id_match ?>  </th> <th>  <?=__Nom_tournoi ?> </th><th>  <?=__Nom_tableau ?>  </th> <th>  <?=__Horaire ?>  </th> <th>  <?=__Table ?> </th><th>  <?=__Comp1 ?>  </th><th>  <?=__Comp2 ?>  </th> <th>  <?=__Statut ?>  </th> <th>  <?=__Act ?>  </th> </tr>
                </thead>
                <tbody>
                <?php 
                            $req='SELECT id_matchs, nom_tournoi, nom_tableau ,horaire_tour, num_table, A.nom_competiteur AS competiteur1, B.nom_competiteur AS competiteur2, type_statut FROM matchs Join competiteur A On id_competiteur1 = A.id_competiteur Join competiteur B On id_competiteur2 = B.id_competiteur join tour on matchs.id_tour = tour.id_tour Join tableau on matchs.id_tableau = tableau.id_tableau join tournoi on tableau.id_tournoi=tournoi.id_tournoi join statut on statut.id_statut = matchs.id_statut ';
                            $req_rencontre = $bdd -> query ($req);
                            while ($rencontre=$req_rencontre->fetch())
                                {
                            ?>
                    <tr> <td> <?=$rencontre['id_matchs']?> </td> <td> <?=$rencontre['nom_tournoi']?> </td><td> <?=$rencontre['nom_tableau']?> </td> <td> <?=$rencontre['horaire_tour']?> </td><td> <?=$rencontre['num_table']?> </td><td> <?=$rencontre['competiteur1']?> </td> <td> <?=$rencontre['competiteur2']?> </td> <td> <?=$rencontre['type_statut']?> </td>   <td> <a href="modification_rencontre.php?action=modif&id_matchs=<?=$rencontre['id_matchs']?>"> <?=__Modifier ?>  </a>/ <a href="supprime_match.php?action=supp&id_matchs=<?=$rencontre['id_matchs']?>"><?=__Supprimer ?> </a></td> </tr>
                            <?php
                            }
                            $req_rencontre->closeCursor();
                            ?>
                </tbody>

            </table>
            <div id="pager" class="pager">  
                <form>  
                    <img src="images/first.png" class="first">  
                    <img src="images/prev.png" class="prev">  
                <input class="pagedisplay" type="text">  
                <img src="images/next.png" class="next">  
                <img src="images/last.png" class="last">  
                <select class="pagesize">  
                            <option selected="selected" value="10">10</option>  
                            <option value="20">20</option>  
                            <option value="30">30</option>  
                            <option value="40">40</option>  
                        </select>  
                </form>  
                </div>
        </div>
        
        <footer>
            
        </footer>
        </div>
        <script type="text/javascript" src="/<?=$Rep?>jQuery/jquery-1.11.1.js"></script>
        <script type="text/javascript"src="/<?=$Rep?>bootstrap/dist/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="/<?=$Rep?>module_jquery/TableSorter/jquery-latest.js"></script>
        <script type="text/javascript" src="/<?=$Rep?>module_jquery/TableSorter/jquery.tablesorter.min.js"></script>
        <script type="text/javascript" src="/<?=$Rep?>module_jquery/TableSorter/jquery.tablesorter.pager.js"></script>
        
        <script type="text/javascript">
        $(document).ready(function() 
                { 
                    $("#TabRencontre").tablesorter({sortList: [[0,1]], widgets: ['zebra']})
                    .tablesorterPager({container: $("#pager")}); 
                }); 
        </script> 
    </body>
</html>