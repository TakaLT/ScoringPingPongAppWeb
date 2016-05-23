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
    echo '<title>gestion match</title>';
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
        <meta http-equiv="refresh" content="60"> 
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="/<?=$Rep?>bootstrap/dist/css/bootstrap.css" rel="stylesheet" type="text/css">
        <link href="/<?=$Rep?>bootstrap/dist/css/bootstrap-theme.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="/<?=$Rep?>module_jquery/TableSorter/themes/blue/style.css" type="text/css" id="" media="print, projection, screen" />
        <link rel="stylesheet" href="/<?=$Rep?>module_jquery/TableSorter/addons/pager/jquery.tablesorter.pager.css" type="text/css" id="" media="print, projection, screen" />
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
        
        //control de l'etat du match        
        if(!empty($_POST))
        {
            //mise en attente du match avec affichage des infos des joueurs
            //creation du fichier pour info tournoi
            if(isset($_POST['attente']))
            {
            $match = $_POST['attente'];
            //echo $match;
            
            $req1="UPDATE matchs SET id_statut= :statut   WHERE id_matchs = :id_match";
            $req_update1= $bdd ->prepare($req1);
            $req_update1->execute (array('statut'=>2,'id_match'=>$match ));
            //reccuperation des info du tournoi
           
            
            //recuperation de info du match            
            $req='SELECT id_matchs,tournoi.id_tournoi, nom_tournoi, nom_tableau ,horaire_tour, num_table,nbre_manche_tournoi,nbre_table_tournoi,id_configuration, A.nom_competiteur AS competiteur1, A.num_dossard AS dossard_competiteur1, B.nom_competiteur AS competiteur2, B.num_dossard AS dossard_competiteur2,A.pays AS paysj1, B.pays AS paysj2,id_statut, temps_mort_j1, temps_mort_j2, faute_cj_j1, faute_cj_j2, faute_cjcr1_j1, faute_cjcr1_j2, faute_cjcr2_j1, faute_cjcr2_j2, forfait_j1, forfait_j2 FROM matchs Join competiteur A On id_competiteur1 = A.id_competiteur Join competiteur B On id_competiteur2 = B.id_competiteur join tour on matchs.id_tour = tour.id_tour Join tableau on matchs.id_tableau = tableau.id_tableau join tournoi on tableau.id_tournoi=tournoi.id_tournoi where id_matchs ="'.$match.'"';
            $req1=$bdd-> query ($req);
            $info = $req1 ->fetch();
            
            //recuperation des info du theme 
            if($info['id_configuration'] != 1)
            {  
                
            $req2='SELECT * FROM tournoi join configuration on tournoi.id_configuration = configuration.id_configuration join parametre on configuration.id_parametre= parametre.id_parametre  where id_tournoi ="'.$info['id_tournoi'].'"';
            $req2=$bdd-> query ($req2);
            $info_theme = $req2 ->fetch();
            }
            
             //sponsor recherche du sponsor
            $req2='SELECT * FROM sponsor Join financement On sponsor.id_sponsor = financement.id_sponsor where financement.id_tournoi ="'.$info['id_tournoi'].'"';
            $req2=$bdd-> query ($req2);
            $sponsor = $req2 ->fetch();

            $nom_sponsor=$sponsor['nom_sponsor'];
          
            $nomj1 =  $info['competiteur1'];
            $nomj2 = $info['competiteur2']; 
            $paysj1 =  $info['paysj1'];
            $paysj2 = $info['paysj2']; 
            $table = $info['num_table']; 
            $statut= $info['id_statut'];
            $manche=$info['nbre_manche_tournoi'];
            $nbre_table=$info['nbre_table_tournoi'];

            //enregistrement dans le Json
            //Json pour info tournoi
            
            
                $Tabinfo['match']=$match;
                $Tabinfo['manche']=$manche;
                $Tabinfo['sponsor']=$nom_sponsor;
                $Tabinfo['table']=$nbre_table;
                $Tabinfo['theme']=$info['id_configuration'];
                //var_dump($Tabinfo);
                //var_dump($info['id_configuration']);
                
               if($info['id_configuration'] != 1)
            { 
                   $Tabinfo['cou_fond']=$info_theme['couleur_fond'];
                   $Tabinfo['cou_text']=$info_theme['couleur_text'];
                   $Tabinfo['taille']=$info_theme['taille_text'];
                   $Tabinfo['gras']=$info_theme['gras'];
                   $Tabinfo['style']=$info_theme['style_text'];
            }
               
                
                
                $strsortie = json_encode( $Tabinfo );
                
                $strsortie = json_encode( $Tabinfo );
                $fic=fopen('tmp/InfoTournoi.json','w');
                fwrite($fic, $strsortie);
                fclose($fic);
                
               //copie des info du tournoi sur un autre serveur publique
                $strsortie1B64=  base64_encode($strsortie);
                $Param1='table='.$table.'&strinfo='.$strsortie1B64;
                $ch1 = curl_init();  
                $url1=$Url_public.'jsonWriteinfo.php';
               // print $url1.'?'.$Param1;
                
                curl_setopt($ch1,CURLOPT_URL,$url1);
                curl_setopt($ch1,CURLOPT_RETURNTRANSFER,true);
                curl_setopt($ch1,CURLOPT_HEADER, false); 
                curl_setopt($ch1, CURLOPT_POST, count($Param1));
                curl_setopt($ch1, CURLOPT_POSTFIELDS, $Param1);    

                $output1=curl_exec($ch1);
                //echo $output1;
                curl_close($ch1);
    

             
                                    
             //Json info table                        
            $NbManche=$manche;
            for ($e=1;$e<=$NbManche;$e++)
            {

            $Tab["scorej1m$e"]='';
            $Tab["scorej2m$e"]='';
            }

            $Tab['resj1']='';
            $Tab['resj2']='';

            $Tab['match']=$match;
            $Tab['nomj1']=$nomj1;
            $Tab['nomj2']=$nomj2;
            $Tab['paysj1']=$paysj1;
            $Tab['paysj2']=$paysj2;
            $Tab['table']=$table;
            $Tab['statut']=$statut;
            //echo json_encode($Tab);


            $strsortie = json_encode( $Tab );

            $fic=fopen('tmp/Table'.$table.'.json','w');
            fwrite($fic, $strsortie);
            fclose($fic);
            
                  // Copie du score sur une url externe
            $strsortieB64=  base64_encode($strsortie);
            $Param='table='.$table.'&str='.$strsortieB64;
            $ch = curl_init();  
            $url= $Url_public.'jsonWrite.php';
            curl_setopt($ch,CURLOPT_URL,$url);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
            curl_setopt($ch,CURLOPT_HEADER, false); 
            curl_setopt($ch, CURLOPT_POST, count($Param));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $Param);    

            $output=curl_exec($ch);
            //echo $output;
            curl_close($ch);
                       
            }            
            //match en cours apres action sur debut de match par le scoreur
            
           if(isset($_POST['encours']))
           {
               $match = $_POST['encours'];
              
            $req1="UPDATE matchs SET id_statut= :statut   WHERE id_matchs = :id_match";
            $req_update1= $bdd ->prepare($req1);
            $req_update1->execute (array('statut'=>1,'id_match'=>$match ));
           }
           
            //match fini apres action sur fin de match du  scoreur
           if(isset($_POST['fin']))
           {
               $match = $_POST['fin'];
                //echo $match;
               
            $req1="UPDATE matchs SET id_statut= :statut   WHERE id_matchs = :id_match";
            $req_update1= $bdd ->prepare($req1);
            $req_update1->execute (array('statut'=>3,'id_match'=>$match ));
           }
           
           //match enregistrer dans la base de données , etat initial des matchs
           if(isset($_POST['enreg']))
           {
                $match = $_POST['enreg'];
               
                $req1="UPDATE matchs SET id_statut= :statut   WHERE id_matchs = :id_match";
                $req_update1= $bdd ->prepare($req1);
                $req_update1->execute (array('statut'=>4,'id_match'=>$match ));
           }
           
           //passage du match en archive remise a zero des Json pour le prochain match
           if(isset($_POST['archive']))
           {
                $match = $_POST['archive'];
                // echo $match;
               
                $req1="UPDATE matchs SET id_statut= :statut   WHERE id_matchs = :id_match";
                $req_update1= $bdd ->prepare($req1);
                $req_update1->execute (array('statut'=>5,'id_match'=>$match ));


                $req='SELECT id_matchs,tournoi.id_tournoi, nom_tournoi, nom_tableau ,horaire_tour, num_table,nbre_manche_tournoi,nbre_table_tournoi, A.nom_competiteur AS competiteur1, A.num_dossard AS dossard_competiteur1, B.nom_competiteur AS competiteur2, B.num_dossard AS dossard_competiteur2,A.pays AS paysj1, B.pays AS paysj2,id_statut, temps_mort_j1, temps_mort_j2, faute_cj_j1, faute_cj_j2, faute_cjcr1_j1, faute_cjcr1_j2, faute_cjcr2_j1, faute_cjcr2_j2, forfait_j1, forfait_j2 FROM matchs Join competiteur A On id_competiteur1 = A.id_competiteur Join competiteur B On id_competiteur2 = B.id_competiteur join tour on matchs.id_tour = tour.id_tour Join tableau on matchs.id_tableau = tableau.id_tableau join tournoi on tableau.id_tournoi=tournoi.id_tournoi where id_matchs ="'.$match.'"';
                $req1=$bdd-> query ($req);
                $info = $req1 ->fetch();

                $nomj1 =  $info['competiteur1'];
                $nomj2 = $info['competiteur2']; 
                $paysj1 =  $info['paysj1'];
                $paysj2 = $info['paysj2']; 
                $table = $info['num_table']; 
                $statut= $info['id_statut'];
                $manche=$info['nbre_manche_tournoi'];

                //remise a zero des json score

                $NbManche=$manche;
                for ($e=1;$e<=$NbManche;$e++)
                {

                $Tab1["scorej1m$e"]='';
                $Tab1["scorej2m$e"]='';
                }

                $Tab1['resj1']='';
                $Tab1['resj2']='';

                $Tab1['match']=$match;
                $Tab1['nomj1']='';
                $Tab1['nomj2']='';
                $Tab1['paysj1']='';
                $Tab1['paysj2']='';
                $Tab1['table']=$table;
                $Tab1['statut']=$statut;
                
                //Creation Json
                $strsortie = json_encode( $Tab1 );
                $fic=fopen('tmp/Table'.$table.'.json','w');
                fwrite($fic, $strsortie);
                fclose($fic);
            
                //Envoi sur serveur externe
                $strsortieB64=  base64_encode($strsortie);
                $Param='table='.$table.'&str='.$strsortieB64;
                $ch = curl_init();  
                $url= $Url_public.'jsonWrite.php';
                curl_setopt($ch,CURLOPT_URL,$url);
                curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
                curl_setopt($ch,CURLOPT_HEADER, false); 
                curl_setopt($ch, CURLOPT_POST, count($Param));
                curl_setopt($ch, CURLOPT_POSTFIELDS, $Param);    

                $output=curl_exec($ch);
                //echo $output;
                curl_close($ch);
                     
            // remise a zero des données Json carton
            $Tab2['match']=$match;
            $Tab2['table']=$table;
            $Tab2['jaunej1']=0;
            $Tab2['jaunej2']=0;
            $Tab2['jr1j1']=0;
            $Tab2['jr1j2']=0;
            $Tab2['jr2j1']=0;
            $Tab2['jr2j2']=0;
            $Tab2['woj1']=0;
            $Tab2['woj2']=0;
            $Tab2['tmj1']=0;
            $Tab2['tmj2']=0;

            $strsortie2 = json_encode( $Tab2 );
            $fic=fopen('tmp/carton_table'.$table.'.json','w');
            fwrite($fic, $strsortie2);
            fclose($fic);
            
           $strsortie2B64=  base64_encode($strsortie2);
           $Param='table='.$table.'&strcarton='.$strsortie2B64;
           $ch2 = curl_init();  
           $url2= $Url_public.'jsonWritecarton.php';
           curl_setopt($ch2,CURLOPT_URL,$url2);
           curl_setopt($ch2,CURLOPT_RETURNTRANSFER,true);
           curl_setopt($ch2,CURLOPT_HEADER, false); 
           curl_setopt($ch2, CURLOPT_POST, count($Param));
           curl_setopt($ch2, CURLOPT_POSTFIELDS, $Param);    

           $output=curl_exec($ch2);
           //echo $output;
           curl_close($ch2);

           }         
        }

        ?>
        <div class="container" align="center">
        <header class="page-header" align="center">
            <h3> <?=__Titre_se ?> </h3>
        </header> 
        
            <div class="row">
                <div class="col-lg-12">
            
            <div class="form-group">
                <form method="POST" action="#">
                <h3> <?=__Table_sel_en_cour ?> </h3>
                <table id="Tab_en_cour" class="tablesorter table-bordered">
                <thead>
                    <tr> <th> <?=__Id_match ?>  </th> <th>  <?=__Nom_tournoi ?> </th><th>  <?=__Nom_tableau ?>  </th> <th>  <?=__Horaire ?>  </th> <th>  <?=__Table ?> </th><th>  <?=__Comp1 ?>  </th><th>  <?=__Comp2 ?>  </th><th>  <?=__Statut ?>  </th>  <th>  <?=__Select ?>  </th> <th>  <?=__Action_att ?>  </th><th>  <?=__Action_cours ?>  </th><th>  <?=__Action_fin ?>  </th> </tr>
                </thead>
                <tbody>
                    
                <?php 
                            $req='SELECT id_matchs, nom_tournoi, nom_tableau ,horaire_tour,nbre_manche_tournoi, num_table, A.nom_competiteur AS competiteur1, B.nom_competiteur AS competiteur2,type_statut FROM matchs Join competiteur A On id_competiteur1 = A.id_competiteur Join competiteur B On id_competiteur2 = B.id_competiteur join tour on matchs.id_tour = tour.id_tour Join tableau on matchs.id_tableau = tableau.id_tableau join tournoi on tableau.id_tournoi=tournoi.id_tournoi join statut on matchs.id_statut=statut.id_statut where matchs.id_statut = 1 ORDER BY horaire_tour ASC, num_table ASC ';
                            $req_rencontre = $bdd -> query ($req);
                            while ($rencontre=$req_rencontre->fetch())
                                {
                            ?>
                    <tr> <td> <?=$rencontre['id_matchs']?> </td> <td> <?=$rencontre['nom_tournoi']?> </td><td> <?=$rencontre['nom_tableau']?> </td> <td> <?=$rencontre['horaire_tour']?> </td><td> <?=$rencontre['num_table']?> </td><td> <?=$rencontre['competiteur1']?> </td> <td> <?=$rencontre['competiteur2']?> </td> <td> <?=$rencontre['type_statut']?> </td>  <td> <a href="match.php?id_match=<?=$rencontre['id_matchs']?>&manche=<?=$rencontre['nbre_manche_tournoi']?>&j1=<?=$rencontre['competiteur1']?>&j2=<?=$rencontre['competiteur2']?>"> <?=__Select ?>  </a></td>  <td><button type="submit" class="btn  btn-primary attente" name="attente" id="AT<?=$rencontre['id_matchs']?>" value="<?=$rencontre['id_matchs']?>" > <span class="glyphicon glyphicon-saved"></span></button> </td><td> <button type="submit" class="btn  btn-primary encours" name="encours" id="EC<?=$rencontre['id_matchs']?>" value="<?=$rencontre['id_matchs']?>" > <span class="glyphicon glyphicon-saved"></span> </button> </td><td> <button type="submit" class="btn  btn-primary fin" name="fin" id="FI<?=$rencontre['id_matchs']?>" value="<?=$rencontre['id_matchs']?>" > <span class="glyphicon glyphicon-saved"></span> </button></td></tr>
                            <?php
                            }
                            $req_rencontre->closeCursor();
                            ?>
                </tbody>
                </table>
                </form>
                <div id="pager1" class="pager col-lg-12">  
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
            
             <div class="form-group">
                 <form method="POST" action="#">
                <h3> <?=__Table_sel_en_Att ?></h3>
                <table id="Tab_att" class="tablesorter table-bordered">
                <thead>
                    <tr> <th> <?=__Id_match ?>  </th> <th>  <?=__Nom_tournoi ?> </th><th>  <?=__Nom_tableau ?>  </th> <th>  <?=__Horaire ?>  </th> <th>  <?=__Table ?> </th><th>  <?=__Comp1 ?>  </th><th>  <?=__Comp2 ?>  </th> <th>  <?=__Statut ?>  </th> <th>  <?=__Select ?>   </th><th>  <?=__Action_att ?>  </th><th>  <?=__Action_cours ?>  </th>  </th> <th>  <?=__Action_fin ?>  </th> </tr>
                </thead>
                <tbody>
                <?php 
                            $req='SELECT id_matchs, nom_tournoi, nom_tableau ,horaire_tour,nbre_manche_tournoi, num_table, A.nom_competiteur AS competiteur1, B.nom_competiteur AS competiteur2,type_statut FROM matchs Join competiteur A On id_competiteur1 = A.id_competiteur Join competiteur B On id_competiteur2 = B.id_competiteur join tour on matchs.id_tour = tour.id_tour Join tableau on matchs.id_tableau = tableau.id_tableau join tournoi on tableau.id_tournoi=tournoi.id_tournoi join statut on matchs.id_statut=statut.id_statut  where matchs.id_statut = 2 ORDER BY horaire_tour ASC, num_table ASC ';
                            $req_rencontre = $bdd -> query ($req);
                            while ($rencontre=$req_rencontre->fetch())
                                {
                            ?>
                    <tr> <td> <?=$rencontre['id_matchs']?> </td> <td> <?=$rencontre['nom_tournoi']?> </td><td> <?=$rencontre['nom_tableau']?> </td> <td> <?=$rencontre['horaire_tour']?> </td><td> <?=$rencontre['num_table']?> </td><td> <?=$rencontre['competiteur1']?> </td> <td> <?=$rencontre['competiteur2']?> </td><td> <?=$rencontre['type_statut']?> </td>   <td> <a href="match.php?id_match=<?=$rencontre['id_matchs']?>&manche=<?=$rencontre['nbre_manche_tournoi']?>&j1=<?=$rencontre['competiteur1']?>&j2=<?=$rencontre['competiteur2']?>"> <?=__Select ?>  </a></td><td> <button type="submit" class="btn  btn-primary attente" name="attente" id="AT<?=$rencontre['id_matchs']?>" value="<?=$rencontre['id_matchs']?>" > <span class="glyphicon glyphicon-saved"></span></button></td><td> <button type="submit" class="btn  btn-primary encours" name="encours" id="EC<?=$rencontre['id_matchs']?>" value="<?=$rencontre['id_matchs']?>" > <span class="glyphicon glyphicon-saved"></span> </button></td><td> <button type="submit" class="btn  btn-primary fin" name="fin" id="FI<?=$rencontre['id_matchs']?>" value="<?=$rencontre['id_matchs']?>" > <span class="glyphicon glyphicon-saved"></span></button></td> </tr>
                            <?php
                            }
                            $req_rencontre->closeCursor();
                            ?>
                </tbody>
                </table>
                 </form>
                <div id="pager2" class="pager col-lg-12">  
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
            
            <div class="form-group">
                <form method="POST" action="#">
                <h3> <?=__Table_sel_enr ?> </h3>
                <table id="Tab_enregistrer" class="tablesorter table-bordered">
                <thead>
                    <tr> <th> <?=__Id_match ?>  </th> <th>  <?=__Nom_tournoi ?> </th><th>  <?=__Nom_tableau ?>  </th> <th>  <?=__Horaire ?>  </th> <th>  <?=__Table ?> </th><th>  <?=__Comp1 ?>  </th><th>  <?=__Comp2 ?>  </th><th>  <?=__Statut ?>  </th>  <th>  <?=__Select ?>  </th> <th>  <?=__Action_att ?>  </th>  <th>  <?=__Action_cours ?>  </th>   <th>  <?=__Action_fin ?>  </th></tr>
                </thead>
                <tbody>
                <?php 
                            $req='SELECT id_matchs, nom_tournoi, nom_tableau ,horaire_tour,nbre_manche_tournoi, num_table, A.nom_competiteur AS competiteur1, B.nom_competiteur AS competiteur2,type_statut FROM matchs Join competiteur A On id_competiteur1 = A.id_competiteur Join competiteur B On id_competiteur2 = B.id_competiteur join tour on matchs.id_tour = tour.id_tour Join tableau on matchs.id_tableau = tableau.id_tableau join tournoi on tableau.id_tournoi=tournoi.id_tournoi join statut on matchs.id_statut=statut.id_statut where matchs.id_statut = 4 ORDER BY horaire_tour ASC, num_table ASC ';
                            $req_rencontre = $bdd -> query ($req);
                            while ($rencontre=$req_rencontre->fetch())
                                {
                            ?>
                    <tr> <td> <?=$rencontre['id_matchs']?> </td> <td> <?=$rencontre['nom_tournoi']?> </td><td> <?=$rencontre['nom_tableau']?> </td> <td> <?=$rencontre['horaire_tour']?> </td><td> <?=$rencontre['num_table']?> </td><td> <?=$rencontre['competiteur1']?> </td> <td> <?=$rencontre['competiteur2']?> </td> <td> <?=$rencontre['type_statut']?> </td>  <td> <a href="match.php?id_match=<?=$rencontre['id_matchs']?>&manche=<?=$rencontre['nbre_manche_tournoi']?>&j1=<?=$rencontre['competiteur1']?>&j2=<?=$rencontre['competiteur2']?>"> <?=__Select ?>  </a></td><td> <button type="submit" class="btn  btn-primary attente"  name="attente" id="AT<?=$rencontre['id_matchs']?>" value="<?=$rencontre['id_matchs']?>" > <span class="glyphicon glyphicon-saved"></span></button></td> <td> <button type="submit" class="btn  btn-primary encours" name="encours"  id="EC<?=$rencontre['id_matchs']?>" value="<?=$rencontre['id_matchs']?>" > <span class="glyphicon glyphicon-saved"></span> </button> </td><td> <button type="submit" class="btn  btn-primary fin" name="fin"  id="FI<?=$rencontre['id_matchs']?>" value="<?=$rencontre['id_matchs']?>" > <span class="glyphicon glyphicon-saved"></span></button></td></tr>
                            <?php
                            }
                            $req_rencontre->closeCursor();
                            ?>
                </tbody>
                </table>
                </form>
                <div id="pager3" class="pager col-lg-12">  
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
            
             <div class="form-group">
                 <form method="POST" action="#">
                <h3> <?=__Table_sel_fin ?> </h3>
                <table id="Tab_fini" class="tablesorter table-bordered">
                <thead>
                    <tr> <th> <?=__Id_match ?>  </th> <th>  <?=__Nom_tournoi ?> </th><th>  <?=__Nom_tableau ?>  </th> <th>  <?=__Horaire ?>  </th> <th>  <?=__Table ?> </th><th>  <?=__Comp1 ?>  </th><th>  <?=__Comp2 ?>  </th><th>  <?=__Statut ?>  </th>  <th>  <?=__Select ?>  </th> <th>  <?=__Action_arch ?>  </th><th>  <?=__Action_att ?>  </th> <th>  <?=__Action_cours ?>  </th>   </tr>
                </thead>
                <tbody>
                <?php 
                            $req='SELECT id_matchs, nom_tournoi, nom_tableau ,horaire_tour,nbre_manche_tournoi, num_table, A.nom_competiteur AS competiteur1, B.nom_competiteur AS competiteur2,type_statut FROM matchs Join competiteur A On id_competiteur1 = A.id_competiteur Join competiteur B On id_competiteur2 = B.id_competiteur join tour on matchs.id_tour = tour.id_tour Join tableau on matchs.id_tableau = tableau.id_tableau join tournoi on tableau.id_tournoi=tournoi.id_tournoi join statut on matchs.id_statut=statut.id_statut where matchs.id_statut = 3 ORDER BY horaire_tour ASC, num_table ASC ';
                            $req_rencontre = $bdd -> query ($req);
                            while ($rencontre=$req_rencontre->fetch())
                                {
                            ?>
                    <tr> <td> <?=$rencontre['id_matchs']?> </td> <td> <?=$rencontre['nom_tournoi']?> </td><td> <?=$rencontre['nom_tableau']?> </td> <td> <?=$rencontre['horaire_tour']?> </td><td> <?=$rencontre['num_table']?> </td><td> <?=$rencontre['competiteur1']?> </td> <td> <?=$rencontre['competiteur2']?> </td> <td> <?=$rencontre['type_statut']?> </td>  <td> <a href="match.php?id_match=<?=$rencontre['id_matchs']?>&manche=<?=$rencontre['nbre_manche_tournoi']?>&j1=<?=$rencontre['competiteur1']?>&j2=<?=$rencontre['competiteur2']?>"> <?=__Select ?>  </a></td> <td><button type="submit" class="btn  btn-primary archive" name="archive" id="AR<?=$rencontre['id_matchs']?>" value="<?=$rencontre['id_matchs']?>" > <span class="glyphicon glyphicon-saved"></span></button></td><td> <button type="submit" class="btn  btn-primary attente" name="attente" id="AT<?=$rencontre['id_matchs']?>" value="<?=$rencontre['id_matchs']?>" > <span class="glyphicon glyphicon-saved"></span></button></td><td> <button type="submit" class="btn  btn-primary encours" name="encours" id="EC<?=$rencontre['id_matchs']?>" value="<?=$rencontre['id_matchs']?>" > <span class="glyphicon glyphicon-saved"></span></button></td></tr>
                            <?php
                            }
                            $req_rencontre->closeCursor();
                            ?>
                </tbody>
                </table>
                 </form>
                <div id="pager4" class="pager col-lg-12">  
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
            
            <div class="form-group">
                <form method="POST" action="#">
                <h3> <?=__Table_sel_archive ?> </h3>
                <table id="Tab_archive" class="tablesorter table-bordered">
                <thead>
                    <tr> <th> <?=__Id_match ?>  </th> <th>  <?=__Nom_tournoi ?> </th><th>  <?=__Nom_tableau ?>  </th> <th>  <?=__Horaire ?>  </th> <th>  <?=__Table ?> </th><th>  <?=__Comp1 ?>  </th><th>  <?=__Comp2 ?>  </th><th>  <?=__Statut ?>  </th>  <th>  <?=__Select ?>  </th>  <th>  <?=__Action_att ?>  </th> <th>  <?=__Action_cours ?>  </th>    <th>  <?=__Action_fin ?>  </th></tr>
                </thead>
                <tbody>
                <?php 
                            $req='SELECT id_matchs, nom_tournoi, nom_tableau ,horaire_tour,nbre_manche_tournoi, num_table, A.nom_competiteur AS competiteur1, B.nom_competiteur AS competiteur2,type_statut FROM matchs Join competiteur A On id_competiteur1 = A.id_competiteur Join competiteur B On id_competiteur2 = B.id_competiteur join tour on matchs.id_tour = tour.id_tour Join tableau on matchs.id_tableau = tableau.id_tableau join tournoi on tableau.id_tournoi=tournoi.id_tournoi join statut on matchs.id_statut=statut.id_statut where matchs.id_statut = 5 ORDER BY horaire_tour ASC, num_table ASC ';
                            $req_rencontre = $bdd -> query ($req);
                            while ($rencontre=$req_rencontre->fetch())
                                {
                            ?>
                    <tr> <td> <?=$rencontre['id_matchs']?> </td> <td> <?=$rencontre['nom_tournoi']?> </td><td> <?=$rencontre['nom_tableau']?> </td> <td> <?=$rencontre['horaire_tour']?> </td><td> <?=$rencontre['num_table']?> </td><td> <?=$rencontre['competiteur1']?> </td> <td> <?=$rencontre['competiteur2']?> </td> <td> <?=$rencontre['type_statut']?> </td>  <td> <a href="match.php?id_match=<?=$rencontre['id_matchs']?>&manche=<?=$rencontre['nbre_manche_tournoi']?>&j1=<?=$rencontre['competiteur1']?>&j2=<?=$rencontre['competiteur2']?>"> <?=__Select ?>  </a></td><td> <button type="submit" class="btn  btn-primary attente" name="attente" id="AT<?=$rencontre['id_matchs']?>" value="<?=$rencontre['id_matchs']?>" > <span class="glyphicon glyphicon-saved"></span></button></td> <td>  <button type="submit" class="btn  btn-primary encours" name="encours" id="EC<?=$rencontre['id_matchs']?>" value="<?=$rencontre['id_matchs']?>" > <span class="glyphicon glyphicon-saved"></span></button></td><td> <button type="submit" class="btn  btn-primary fin" name="fin" id="FI<?=$rencontre['id_matchs']?>" value="<?=$rencontre['id_matchs']?>" > <span class="glyphicon glyphicon-saved"></span></button></td></tr>
                            <?php
                            }
                            $req_rencontre->closeCursor();
                            ?>
                </tbody>
                </table>
                </form>
                <div id="pager5" class="pager col-lg-12">  
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
               
                   
            <a href="menu.php" ><?=__Retour ?></a>
        </div> 
            </div>
        
        <footer>
            
        </footer>
        </div>
        <script type="text/javascript" src="/<?=$Rep?>jQuery/jquery-1.11.1.js"></script>
        <script src="/<?=$Rep?>bootstrap/dist/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="/<?=$Rep?>module_jquery/TableSorter/jquery-latest.js"></script>
        <script type="text/javascript" src="/<?=$Rep?>module_jquery/TableSorter/jquery.tablesorter.min.js"></script>
        <script type="text/javascript" src="/<?=$Rep?>module_jquery/TableSorter/jquery.tablesorter.pager.js"></script>
        <script type="text/javascript">
            $(document).ready(function() 
                { 
                 
                if ($("#Tab_en_cour").find("tr").size() > 1)
                {
                 $("#Tab_en_cour").tablesorter({widgets: ['zebra']})
                            .tablesorterPager({container: $("#pager1")});
                }
                if ($("#Tab_att").find("tr").size() > 1)
                {
                 $("#Tab_att").tablesorter({widgets: ['zebra']})
                            .tablesorterPager({container: $("#pager2")}); 
                }
                if ($("#Tab_enregistrer").find("tr").size() > 1)
                {
                  $("#Tab_enregistrer").tablesorter({widgets: ['zebra']})
                            .tablesorterPager({container: $("#pager3")}); 
                }
                 if ($("#Tab_fini").find("tr").size() > 1)
                {
                  $("#Tab_fini").tablesorter({widgets: ['zebra']})
                            .tablesorterPager({container: $("#pager4")}); 
                }  
                 if ($("#Tab_archive").find("tr").size() > 1)
                {
                  $("#Tab_archive").tablesorter({widgets: ['zebra']})
                            .tablesorterPager({container: $("#pager5")}); 
                }  
                }); 
        
        </script> 
    </body>
</html>
