<?php
// On démarre la session 
session_start ();

// inclusion du fichier connect et conf 
include_once('lang/lang_conf.php');


// On récupère nos variables de session
if (isset($_SESSION['utilisateur']) && ($_SESSION['utilisateur'] != ''))
    {

    // On teste pour voir si nos variables ont bien été enregistrées
    echo '<html>';
    echo '<head>';
    echo '<title>Tour</title>';
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
        <title></title>
        <link rel="stylesheet" href="/<?=$Rep?>module_jquery/TableSorter/themes/blue/style.css" type="text/css" id="" media="print, projection, screen" />
        <link rel="stylesheet" href="/<?=$Rep?>module_jquery/TableSorter/addons/pager/jquery.tablesorter.pager.css" type="text/css" id="" media="print, projection, screen" />
        <link rel="stylesheet" href="/<?=$Rep?>module_jquery/datetimepicker-master/jquery.datetimepicker.css" type="text/css"  />
        <link href="/<?=$Rep?>bootstrap/dist/css/bootstrap.css" rel="stylesheet" type="text/css">
        <link href="/<?=$Rep?>bootstrap/dist/css/bootstrap-theme.css" rel="stylesheet" type="text/css">
        <link href="/<?=$Rep?>CSS/style.css" rel="stylesheet" type="">
        
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
        
        if ( ( $_GET['action']=='modif' ) && ( $_GET['id_tour']!='' ) ) 
          {
            //alimentation des champs
            $req="SELECT * FROM tour  WHERE id_tour='".$_GET['id_tour']."'";
            $req=$bdd-> query ($req);
            $tour= $req ->fetch();
            
          }
        
        if (isset($_POST['modification_tour'])) 
            {
                //recuperation champs        
                $num_tour=  htmlspecialchars($_POST['num_tour']);
                $id_tour=$_GET['id_tour'];
                $horaire=$_POST['horaire'];

                //changement de format de la date pour la comparaison mysql
                $time = date_create($horaire);
                $time= date_format($time,'Y-m-d H:i:s');

                $req="SELECT * FROM tour WHERE num_tour = '".$num_tour."' AND  horaire_tour='".$time."' ";
                $req_verif=$bdd->query($req);
                $nbreligne=$req_verif->rowCount();

                 if ($nbreligne < 1)
                {
                //creation de la requete de mise a jour et insertion des données dans la base 
                $req='UPDATE tour SET  horaire_tour =:horaire , num_tour =:num WHERE id_tour =:id_tour ';
                $req_tour= $bdd->prepare($req);
                $req_tour->execute (array('horaire'=>$horaire, 'num'=>$num_tour, 'id_tour'=>$id_tour ));

                }
                else
                    {
                    echo '<h3>'.__mes3.'</h3>';
                }
            }
        ?>
        <div class="container" align="center">
        <header class="page-header">
            <h3><?=__Titre_tour ?> </h3>
        </header>
        <div class="row">
            <div class="col-lg-2 col-lg-offset-5"> 
            <form method="POST" action="#">
                <div class="form-group">
                    <label for="num_tour_mod"><?=__Num_t ?> :</label><br/>
                    <input type="text" name="num_tour" id="num_tour_mod" class="form-control" value=" <?php echo $tour['num_tour'] ?>"required="required"/>
                </div>
                <div class="form-group">
                    <label for="default_datetimepicker"><?=__Horaire?> :</label><br/>
                    <input type="text" name="horaire" id="default_datetimepicker" class="form-control" value="<?=$tour['horaire_tour'] ?>" required="required" />
                </div>
                <div class="form-group">
                    <input type="reset" name="reset" class="btn btn-default" value="<?=__Reset ?> "/> <input type="submit" name="modification_tour" class="btn btn-default" value="<?=__Modifier ?> "/>
                </div>
            </form>   
                <a href="menu.php" ><?=__Retour ?></a>
                <a href="tour.php" ><?=__Retour_tour ?></a>
                </div>    
            </div>
        <div class="form-group">
            <h3> <?=__Table_to ?> </h3>
            <table id="TabTour" class="tablesorter table-bordered">
                <thead>
                    <tr> <th>  <?=__Id_tour ?>  </th> <th>  <?=__Horaire ?> </th><th>  <?=__Num_t ?>  </th> <th>  <?=__Act ?>  </th> </tr>
                </thead>
                <tbody>
                <?php 
                            $req='SELECT * FROM tour order by horaire_tour asc';
                            $req_tour = $bdd -> query ($req);
                            while ($tour=$req_tour->fetch())
                                {
                            ?>
                    <tr> <td> <?=$tour['id_tour']?> </td> <td> <?=$tour['horaire_tour']?> </td><td> <?=$tour['num_tour']?> </td> <td> <a href="modification_tour.php?action=modif&id_tour=<?=$tour['id_tour']?>"> <?=__Modifier ?>  </a>/ <a href="supprime_tour.php?action=supp&id_tour=<?=$tour['id_tour']?>"><?=__Supprimer ?> </a></td> </tr>
                            <?php
                            }
                            $req_tour->closeCursor();
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
        <script src="/<?=$Rep?>bootstrap/dist/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="jQuery/jquery-ui-1.11.0/jquery-ui.js"></script>
        <script type="text/javascript" src="module_jquery/datetimepicker-master/jquery.datetimepicker.js"></script>
        <script type="text/javascript">
            
            $('#default_datetimepicker').datetimepicker({
                    formatTime:'H:i',
                    formatDate:'d.m.Y',
                    defaultTime:'14:00',
                    step: 5,
                    dayOfWeekStart: 1
                    
            });
          </script>
        <script type="text/javascript" src="/<?=$Rep?>module_jquery/TableSorter/jquery-latest.js"></script>
        <script type="text/javascript" src="/<?=$Rep?>module_jquery/TableSorter/jquery.tablesorter.min.js"></script>
        <script type="text/javascript" src="/<?=$Rep?>module_jquery/TableSorter/jquery.tablesorter.pager.js"></script>  
          <script type="text/javascript">
            $(document).ready(function() 
                { 
                  $("#TabTour").tablesorter({ widgets: ['zebra']})
                    .tablesorterPager({container: $("#pager")}); 
                }); 
        </script> 
    </body>
</html>