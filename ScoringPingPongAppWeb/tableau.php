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
    echo '<title>Tableau</title>';
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
        
        if(isset($_POST['valide_tableau']))
            
        {
            //recuperation variable
            $nom_tableau=  htmlspecialchars($_POST['nom_tableau']);
            $descriptif= htmlspecialchars($_POST['descriptif']);
            $id_tournoi=$_POST['tournoi'];
          
            $req="SELECT * FROM tableau WHERE id_tournoi = '".$id_tournoi."'  AND nom_tableau ='".$nom_tableau."' ";
            $req_verif=$bdd->query($req);
            $nbreligne=$req_verif->rowCount();
            
             if ($nbreligne < 1)                 
            {
                $req_tab='INSERT INTO tableau (nom_tableau, Descriptif, id_tournoi) VALUES (:nom, :descriptif, :id_tournoi)';
                $req_insert_tab=$bdd->prepare($req_tab);
                $req_insert_tab->execute(array('nom'=>$nom_tableau, 'descriptif'=>$descriptif, 'id_tournoi'=>$id_tournoi));
            }
            else
                {
                echo '<h3>'.__mes2.'</h3>';
            }
        }
      
        ?>
        <div class="container" align="center">
        
        <header class="page-header">
            <h2><?=__Titre_tableau ?> </h2>            
        </header>
        <div class="row">
            <div class="col-lg-2 col-lg-offset-5"> 
            <form method="POST" action="#">
                <div class="form-group">
                    <label for="tournoi"><?=__Nom_tournoi ?> :</label><br/>
                        <select name="tournoi" id="tournoi" class="form-control">
                        <?php
                        
                        $req='SELECT * FROM tournoi';
                        $req_tournoi = $bdd -> query ($req);
                        while ($data_tournoi=$req_tournoi->fetch())
                            {
                        ?>
                        <option value="<?php echo $data_tournoi['id_tournoi']; ?>"><?php echo $data_tournoi['nom_tournoi']; ?></option>
                        <?php
                        }
                        $req_tournoi->closeCursor();
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="nom_tableau"><?=__Nom_tableau ?> :</label><br/>
                    <input type="text" name="nom_tableau" id="nom_tableau" class="form-control" required="required"/>
                </div>
                <div class="form-group">
                    <label for="descriptif"><?=__Descriptif ?> :</label><br/>
                    <input type="text" name="descriptif" id="descriptif" class="form-control" placeholder="<?=__Fac ?>"/>
                </div>
                <div class="form-group">
                    <input type="reset" name="reset" class="btn btn-default" value="<?=__Reset ?> "/> <input type="submit" name="valide_tableau" class="btn btn-default" value="<?=__Valide ?> "/>
                </div>
            </form>
                <a href="menu.php" ><?=__Retour ?></a><br/>
                </div>    
            </div>
            <div class="form-group">
                <h3> <?=__Table_ta ?> </h3>
                <table id="TabTournoi" class="tablesorter table-bordered">
                    <thead>
                        <tr> <th>  <?=__Id_tableau ?>  </th> <th>  <?=__Nom_tableau ?> </th><th>  <?=__Descriptif ?>  </th><th>  <?=__Nom_tournoi ?>  </th> <th>  <?=__Act ?>  </th> </tr>
                    </thead>
                    <tbody>
                    <?php 
                                $req='SELECT * FROM tableau join tournoi On tableau.id_tournoi = tournoi.id_tournoi';
                                $req_tableau = $bdd -> query ($req);
                                while ($tableau=$req_tableau->fetch())
                                    {
                                ?>
                        <tr> <td> <?=$tableau['id_tableau']?> </td> <td> <?=$tableau['nom_tableau']?> </td><td> <?=$tableau['Descriptif']?> </td> <td> <?=$tableau['nom_tournoi']?> </td>  <td> <a href="modification_tableau.php?action=modif&id_tableau=<?=$tableau['id_tableau']?>"> <?=__Modifier ?>  </a>/ <a href="supprime_tableau.php?action=supp&id_tableau=<?=$tableau['id_tableau']?>"><?=__Supprimer ?> </a></td> </tr>
                                <?php
                                }
                                $req_tableau->closeCursor();
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
        <script type="text/javascript">
            $(document).ready(function() 
                { 
                    $("#TabTournoi").tablesorter(); 
                }); 
        </script> 
    </body>
</html>
