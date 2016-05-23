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
    echo '<title>Competiteur</title>';
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
        include 'connexion.php';
        
         if ( ( $_GET['action']=='modif' ) && ( $_GET['id_competiteur']!='' ) ) 
          {
            //echo 'je suis la';
            //alimentation des champs 
            $req="SELECT  * FROM competiteur  WHERE id_competiteur='".$_GET['id_competiteur']."'";
            $req=$bdd-> query ($req);
            $competiteur = $req ->fetch();
            
          }
       
       
        if (isset($_POST['modif_competiteur']))
        {
            
        $nom=  htmlspecialchars($_POST['nom_competiteur']);
        $prenom= htmlspecialchars($_POST['prenom_competiteur']);
        $sexe=  htmlspecialchars($_POST['sexe']);
        $num=  htmlspecialchars($_POST['num_dossard']);
        $categorie= htmlspecialchars($_POST['categorie']);
        $pays=  htmlspecialchars($_POST['pays']);
        $rang= htmlspecialchars($_POST['rang']);
        
        //requete si jour deja rentrer dans la base 
        $req="SELECT * FROM competiteur WHERE nom_competiteur ='".$nom."'  AND prenom_competiteur ='".$prenom."' AND sexe ='".$sexe."'AND pays ='".$pays."' AND num_dossard='".$num."'  ";
            $req_verif=$bdd->query($req);
            $nbreligne=$req_verif->rowCount();
            
             if ($nbreligne < 1)
                 
            {
                
                $req='UPDATE competiteur SET nom_competiteur =:nom, prenom_competiteur=:prenom, num_dossard=:num, sexe=:sexe, categorie_reel=:cat, pays=:pays, rang=:rang WHERE id_competiteur =:id_competiteur ';
                $req_modif= $bdd->prepare($req);
                $req_modif->execute (array('nom'=>$nom, 'prenom'=>$prenom, 'num'=>$num, 'sexe'=>$sexe, 'cat'=>$categorie,'pays'=>$pays, 'rang'=>$rang, 'id_competiteur'=>$_GET['id_competiteur']));
              
            
            }
            else
                {
                echo '<h3>'.__mes4.'</h3>';
            }
     
            
        }
        ?>
        <div class="container" align="center">
        <header class="page-header">
            <h3><?=__Titre_modif_competiteur ?></h3>
        </header>
        <div class="row">
            <div class="col-lg-2 col-lg-offset-5"> 
            <form method="POST" action="#">
                <div class="form-group">
                    <label for="nom_competiteur_mod"><?=__Nom ?> :</label><br/>
                    <input type="text" name="nom_competiteur" id="nom_competiteur_mod" class="form-control" value="<?php echo $competiteur['nom_competiteur'] ?>" required="required"/>
                </div>
                <div class="form-group">
                    <label for="prenom_competiteur_mod"><?=__Prenom ?> :</label><br/>
                    <input type="text" name="prenom_competiteur" id="prenom_competiteur_mod" class="form-control" value="<?php echo $competiteur['prenom_competiteur'] ?>" required="required"/>
                </div> 
                <div class="form-group">
                    <label for="num_dossard_mod"><?=__Num_d ?> :</label><br/>
                    <input type="text" name="num_dossard" id="num_dossard_mod" class="form-control" value="<?php echo $competiteur['num_dossard'] ?>" required="required"/>
                </div>
                <div class="form-group">
                    <label for="sexe_mod"><?=__Sexe ?> :</label><br/>
                    <input type="text" name="sexe" id="sexe_mod" class="form-control" value="<?php echo $competiteur['sexe'] ?>" required="required"/>
                </div>
                <div class="form-group">
                    <label for="categorie_mod"><?=__Cat_r ?> :</label><br/>
                    <input type="text" name="categorie" id="categorie_mod" class="form-control" value="<?php echo $competiteur['categorie_reel'] ?>" placeholder="<?=__Fac ?>"/>
                </div>
                <div class="form-group">
                    <label for="pays_mod"><?=__Pays ?> :</label><br/>
                  
                    <select name="pays" id="pays" class="form-control" required="required" >
                        <option value="<?php echo $competiteur['pays'] ?>"><?php echo $competiteur['pays'] ?></option>
                        <option value="AT"><?=__AT ?> </option>
                        <option value="BE"><?=__BE ?> </option>
                        <option value="BG"><?=__BG ?> </option>
                        <option value="BY"><?=__BY ?> </option>
                        <option value="CY"><?=__CY ?> </option>
                        <option value="CZ"><?=__CZ ?> </option>
                        <option value="DE"><?=__DE ?> </option>
                        <option value="DK"><?=__DK ?> </option>
                        <option value="EE"><?=__EE ?> </option>
                        <option value="EN"><?=__EN ?> </option>
                        <option value="EL"><?=__EL ?> </option>
                        <option value="ES"><?=__ES ?> </option>
                        <option value="FI"><?=__FI ?> </option>
                        <option value="FR"><?=__FR ?> </option>
                        <option value="HU"><?=__HU ?> </option>
                        <option value="HR"><?=__HR ?> </option>
                        <option value="IE"><?=__IE ?> </option>
                        <option value="IL"><?=__IL ?> </option>
                        <option value="IT"><?=__IT ?> </option>
                        <option value="LU"><?=__LU ?> </option> 
                        <option value="LT"><?=__LT ?> </option>
                        <option value="LV"><?=__LV ?> </option>
                        <option value="MD"><?=__MD ?> </option>
                        <option value="MT"><?=__MT ?> </option>
                        <option value="NL"><?=__NL ?> </option>
                        <option value="PL"><?=__PL ?> </option>
                        <option value="PT"><?=__PT ?> </option> 
                        <option value="RO"><?=__RO ?> </option>
                        <option value="RS"><?=__RS ?> </option>
                        <option value="RU"><?=__RU ?> </option>
                        <option value="SE"><?=__SE ?> </option>
                        <option value="SI"><?=__SI ?> </option>
                        <option value="SK"><?=__SK ?> </option>
                        <option value="UK"><?=__UK ?> </option>
        
                    </select>
                    
                </div>
                <div class="form-group">
                    <label for="rang_mod"><?=__Rang ?> :</label><br/>
                    <input type="text" name="rang" id="rang_mod" class="form-control" value="<?php echo $competiteur['rang'] ?>" placeholder="<?=__Fac ?>" />
                </div>
                <div class="form-group">
                    <input type="reset" name="reset" class="btn btn-default" value="<?=__Reset ?> "/> <input type="submit" name="modif_competiteur" class="btn btn-default" value="<?=__Modifier ?> "/>
                </div>             
            </form>
                <a href="menu.php" ><?=__Retour ?></a><br/>
                <a href="competiteur.php" ><?=__Retour_competiteur ?></a>
                </div>    
            </div>
         
            <div class="form-group">
                <h3> <?=__Table_c ?> </h3>
                <table id="TabCompetiteur" class="tablesorter table-bordered">
                    <thead>
                        <tr> <th>  <?=__Id_competiteur ?>  </th> <th>  <?=__Nom ?> </th><th>  <?=__Prenom ?>  </th><th>  <?=__Num_d ?>  </th> <th>  <?=__Sexe ?>  </th> <th>  <?=__Cat_r ?> </th><th>  <?=__Pays ?>  </th><th>  <?=__Rang ?>  </th><th>  <?=__Act ?>  </th> </tr>
                    </thead>
                    <tbody>
                    <?php 
                        $req='SELECT * FROM competiteur';
                        $req_competiteur = $bdd -> query ($req);
                        while ($com=$req_competiteur->fetch())
                            {
                        ?>
                        <tr> <td> <?=$com['id_competiteur']?> </td> <td> <?=$com['nom_competiteur']?> </td><td> <?=$com['prenom_competiteur']?> </td> <td> <?=$com['num_dossard']?> </td> <td> <?=$com['sexe']?> </td><td> <?=$com['categorie_reel']?> </td><td> <?=$com['pays']?> </td><td> <?=$com['rang']?> </td> <td> <a href="modification_competiteur.php?action=modif&id_competiteur=<?=$com['id_competiteur']?>"> <?=__Modifier ?>  </a>/ <a href="supprime_competiteur.php?action=supp&id_competiteur=<?=$com['id_competiteur']?>"><?=__Supprimer ?> </a></td> </tr>
                        <?php
                        }
                        $req_competiteur->closeCursor();
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
        <script type="text/javascript" src="/<?=$Rep?>bootstrap/dist/js/bootstrap.min.js"></script>
       <script type="text/javascript" src="/<?=$Rep?>module_jquery/TableSorter/jquery-latest.js"></script>
        <script type="text/javascript" src="/<?=$Rep?>module_jquery/TableSorter/jquery.tablesorter.min.js"></script>
        <script type="text/javascript" src="/<?=$Rep?>module_jquery/TableSorter/jquery.tablesorter.pager.js"></script>
        <script type="text/javascript">
            $(document).ready(function() 
                { 
                    $("#TabCompetiteur").tablesorter( {widgets: ['zebra']})
                    .tablesorterPager({container: $("#pager")});  
                }); 
        </script>
    </body>
</html>
