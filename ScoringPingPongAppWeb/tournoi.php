<?php
// On démarre la session et on inclus le fichier de configuraion
session_start ();
include_once('lang/lang_conf.php');

// On récupère nos variables de session
if (isset($_SESSION['utilisateur']) && ($_SESSION['utilisateur'] != ''))
    {

    // On teste pour voir si nos variables ont bien été enregistrées
    echo '<html>';
    echo '<head>';
    echo '<title>Tournoi</title>';
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
        <link href="/<?=$Rep?>bootstrap/dist/css/bootstrap.css" rel="stylesheet" type="text/css">
        <link href="/<?=$Rep?>bootstrap/dist/css/bootstrap-theme.css" rel="stylesheet" type="text/css">
        <link href="/<?=$Rep?>CSS/style.css" rel="stylesheet" type="text/css" >
        <link rel="stylesheet" href="/<?=$Rep?>module_jquery/TableSorter/themes/blue/style.css" type="text/css" id="" media="print, projection, screen" />
        <link type="text/css" href="/<?=$Rep?>module_jquery/Aristo-jQuery-UI-Theme-master/css/Aristo/Aristo.css" rel="stylesheet" />	
        
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
        if (isset($_POST['validation_tournoi']))
        {
                  
            //enregistrement dans des variable avec controle
            $nom_tournoi = htmlspecialchars($_POST['nom_tournoi']);
            $date_debut = $_POST['date_debut'];
            $date_fin = $_POST['date_fin'];
            $type_tournoi = htmlspecialchars($_POST['type_tournoi']);
            $nbre_manche = $_POST['nbr_manche'];
            $nbre_tour = $_POST['nbr_tour'];
            $nbre_table = $_POST['nbr_table'];
            
            //controle si tournoi deja rentrer
            $req="SELECT * FROM tournoi WHERE nom_tournoi = '".$nom_tournoi."'  AND date_debut_tournoi ='".$date_debut."' AND date_fin_tournoi ='".$date_fin."' AND type_tournoi = '".$type_tournoi."' AND nbre_manche_tournoi = '".$nbre_manche."' AND nbre_table_tournoi = '".$nbre_table."' AND nbe_tour_tournoi = '".$nbre_tour."' AND id_configuration = '".$_POST['theme']."' ";
            $req_verif=$bdd->query($req);
            $nbreligne=$req_verif->rowCount();
            
             if ($nbreligne < 1)                 
            {
            //creation de la requete et insertion des données dans la base 
            $req='INSERT INTO tournoi (nom_tournoi, date_debut_tournoi, date_fin_tournoi, nbre_manche_tournoi, type_tournoi, nbre_table_tournoi, nbe_tour_tournoi, id_configuration) values ( :nom, :debut, :fin, :manche, :type, :table, :tour, :id_conf)';
            $req_tournoi= $bdd->prepare($req);
            $req_tournoi->execute (array('nom'=>$nom_tournoi, 'debut'=>$date_debut, 'fin'=>$date_fin, 'manche'=>$nbre_manche,'type'=>$type_tournoi ,'table'=>$nbre_table,'tour'=>$nbre_tour, 'id_conf'=>$_POST['theme']));
                      
          
            }
            else
                {
                echo '<h3>'.__mes1.'</h3>';
            }
            
        }
        ?>
        <div class="container" align='center'>
        <header class="page-header">
            <h2><?=__Titre_tournoi ?> </h2>
             
        </header>
        
            <div class="row">
                <div class="col-lg-2 col-lg-offset-5"> 
            
            <form  method="POST" action="#" >
                <div class="form-group">
                    <label for="nom_tournoi"><?=__Nom_tournoi ?> : </label><br/>
                    <input type="text" name="nom_tournoi" id="nom_tournoi" class="form-control" required="required" />
                </div>
                <div class="form-group">
                    <label for="datepicker1"><?=__Date_d ?> :</label><br/>
                    <input type="text" name="date_debut" id="datepicker1"class="datepicker form-control" required="required"/>
                </div>
                <div class="form-group">
                    <label for="datepicker2"><?=__Date_f ?> :</label><br/>
                    <input type="text" name="date_fin" id="datepicker2" class="datepicker form-control" required="required"/>
                </div>
                <div class="form-group">
                    <label for="type_tournoi"><?=__Type_t ?> : </label><br/>
                    <input type="text" name="type_tournoi" id="type_tournoi" class="form-control" placeholder="<?=__Fac ?>"/>
                </div>
                <div class="form-group">
                    <label for="nbr_manche"><?=__Nbre_m ?> :</label><br/>
                    <input type="text" name="nbr_manche" id="nbr_manche" class="form-control" required="required" />
                </div>
                <div class="form-group">
                    <label for="nbr_tour"><?=__Nbre_to ?> :</label><br/>
                    <input type="text" name="nbr_tour" id="nbr_manche" class="form-control" required="required" />
                </div>
                <div class="form-group">
                    <label for="nbr_table"><?=__Nbre_ta ?> :</label><br/>
                    <input type="text" name="nbr_table" id="nbr_table" class="form-control" required="required" />
                </div>
                <div class="form-group">
                    <label for="theme"><?=__Choix_t ?> :</label><br/>
                    <select name="theme" id="theme" class="form-control">
                        <?php
                        
                        $req='SELECT * FROM configuration';
                        $req_theme = $bdd -> query ($req);
                        while ($data_theme=$req_theme->fetch())
                            {
                        ?>
                        <option value="<?php echo $data_theme['id_configuration']; ?>"><?php echo $data_theme['nom_configuration']; ?></option>
                        <?php
                        }
                        $req_theme->closeCursor();
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <input type="reset" name="reset" class="btn btn-default" value="<?=__Reset ?> "/> <input type="submit" name="validation_tournoi" class="btn btn-default"value="<?=__Valide ?> "/>
                </div>    
            </form>
                <a href="menu.php" ><?=__Retour ?></a>
            </div>    
            </div>
            <div class="form-group">
                <h3> <?=__Table_t ?> </h3>
                <table id="TabTournoi" class="tablesorter table-bordered">
                    <thead>
                        <tr> <th>  <?=__Id_tournoi ?>  </th> <th>  <?=__Nom_tournoi ?> </th><th>  <?=__Date_d ?>  </th><th>  <?=__Date_f ?>  </th> <th>  <?=__Type_t ?>  </th> <th>  <?=__Nbre_m ?> </th><th>  <?=__Nbre_to ?>  </th><th>  <?=__Nbre_ta ?>  </th> <th>  <?=__Id_configuration ?>  </th> <th>  <?=__Act ?>  </th> </tr>
                    </thead>
                    <tbody>
                    <?php 
                                $req='SELECT * FROM tournoi join configuration on tournoi.id_configuration = configuration.id_configuration';
                                $req_theme = $bdd -> query ($req);
                                while ($tournoi=$req_theme->fetch())
                                    {
                                ?>
                        <tr> <td> <?=$tournoi['id_tournoi']?> </td> <td> <?=$tournoi['nom_tournoi']?> </td><td> <?=$tournoi['date_debut_tournoi']?> </td> <td> <?=$tournoi['date_fin_tournoi']?> </td> <td> <?=$tournoi['type_tournoi']?> </td><td> <?=$tournoi['nbre_manche_tournoi']?> </td><td> <?=$tournoi['nbe_tour_tournoi']?> </td><td> <?=$tournoi['nbre_table_tournoi']?> </td> <td> <?=$tournoi['nom_configuration']?> </td> <td> <a href="modification_tournoi.php?action=modif&id_tournoi=<?=$tournoi['id_tournoi']?>"> modification </a>/ <a href="supprime_tournoi.php?action=supp&id_tournoi=<?=$tournoi['id_tournoi']?>">supprimer</a></td> </tr>
                                <?php
                                }
                                $req_theme->closeCursor();
                                ?>
                    </tbody>

                </table>
            </div>
        
        <footer>
            
        </footer>
        </div>
        <script type="text/javascript" src="/<?=$Rep?>jQuery/jquery-1.11.1.js"></script>        
        <script type="text/javascript" src="/<?=$Rep?>module_jquery/TableSorter/jquery.tablesorter.min.js"></script>
        <script type="text/javascript" src="/<?=$Rep?>bootstrap/dist/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="/<?=$Rep?>jQuery/jquery-ui-1.11.0/jquery-ui.js"></script>   

        <script type="text/javascript">
            
            $(function(){
                $( "#datepicker1" ).datepicker({dateFormat: 'yy-mm-dd', firstDay:1, 
                defaultDate: "+1w",
                changeMonth: true,
                numberOfMonths: 1,
                onClose: function( selectedDate ) {
                $( "#datepicker2" ).datepicker( "option", "minDate", selectedDate );
                }
                });
                $( "#datepicker2" ).datepicker({dateFormat: 'yy-mm-dd', firstDay:1, 
                defaultDate: "+1w",
                changeMonth: true,
                numberOfMonths: 1,
                onClose: function( selectedDate ) {
                $( "#datepicker1" ).datepicker( "option", "maxDate", selectedDate );
                }
                });
               
            });
            $(document).ready(function() 
                { 
                    $("#TabTournoi").tablesorter(); 
                }); 
        </script> 
        
    </body>
</html>
