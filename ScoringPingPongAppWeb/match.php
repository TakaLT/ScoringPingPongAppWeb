<?php
// On démarre la session 
session_start ();
//on inclut le fichier de configuration
include_once('lang/lang_conf.php');
//on se connect à la base de donnée
include 'connexion.php';

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
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            // echo 'id du match'.$_POST['matchs'];
             $id_match=$_GET['id_match'];
             $NbManche=$_GET['manche'];

            $req='SELECT id_matchs,tournoi.id_tournoi, nom_tournoi, nom_tableau ,horaire_tour, num_table,nbre_manche_tournoi,nbre_table_tournoi, A.nom_competiteur AS competiteur1, A.num_dossard AS dossard_competiteur1, B.nom_competiteur AS competiteur2, B.num_dossard AS dossard_competiteur2,A.pays AS paysj1, B.pays AS paysj2,   temps_mort_j1, temps_mort_j2, faute_cj_j1, faute_cj_j2, faute_cjcr1_j1, faute_cjcr1_j2, faute_cjcr2_j1, faute_cjcr2_j2, forfait_j1, forfait_j2 FROM matchs Join competiteur A On id_competiteur1 = A.id_competiteur Join competiteur B On id_competiteur2 = B.id_competiteur join tour on matchs.id_tour = tour.id_tour Join tableau on matchs.id_tableau = tableau.id_tableau join tournoi on tableau.id_tournoi=tournoi.id_tournoi where id_matchs ="'.$_GET['id_match'].'"';
            $req=$bdd-> query ($req);
            $match = $req ->fetch();

            //sponsor recherche du sponsor
            $req2='SELECT * FROM sponsor Join financement On sponsor.id_sponsor = financement.id_sponsor where financement.id_tournoi ="'.$match['id_tournoi'].'"';
            $req2=$bdd-> query ($req2);
            $sponsor = $req2 ->fetch();

            $nom_sponsor=$sponsor['nom_sponsor'];
            $id_match=$match['id_matchs'];
        
        ?>
        <header class="page-header" >
            <div class="container">
                <div class="form ">
                    <div class="row">
                        <div class="col-md-2 col-md-offset-5 ">
                            <h2><?=__Titre_ma?> </h2>
                        </div>
                    </div>    
                    <div class="row">   
                        <div class="col-md-2 col-md-offset-1">
                            <?=__Nom_tournoi?> :
                        </div>
                        <div class="col-md-2">
                            <input type="text" name="nom_tournoi" value="<?= $match['nom_tournoi']; ?> " readonly="readonly" /> 
                        </div>
                        <div class="col-md-2 col-md-offset-1">
                            <?=__Nom_tableau?> :
                        </div>
                        <div class="col-md-2">
                            <input type="text" name="nom_tableau" value="<?= $match['nom_tableau']; ?> " readonly="readonly"/>
                        </div>
                    </div>
                </div>    
                
                <div class="row">
                    <div class="col-md-2 col-md-offset-1">
                        <?=__Horaire?> :
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="horaire" value="<?= $match['horaire_tour']; ?> " readonly="readonly" />
                    </div>
                    <div class="col-md-2 col-md-offset-1">                        
                        <?=__Table?> :
                    </div>
                    <div class="col-md-2 "> 
                        <input type="text" name="table" value="<?= $match['num_table']; ?>"  readonly="readonly" />
                    </div>
                </div>
            </div>
        </header>
        <div class="container" align='center'>  
            <div class="form-group">
                    <button type="button" name="debut_m" id="debut_m" class="btn btn-default" value="debut" ><?=__Debut_m?></button>
                    </div>
            <div id="infoj1" class="row" >
                <div class="col-md-5 col-md-offset-1">            
                    <h4><?=__Nom?> : <?=$match['competiteur1'];?></h4>
                </div>
                <div class="col-md-3 col-md-offset-1">
                    <h4><?=__Num_d?> : <?=$match['dossard_competiteur1'];?></h4>
                </div>
            </div>
            
                
            <section id="scorej1">            
                <div class="row" >
                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <table width="100%" class="table-bordered" >                 
                                <tbody>
                                    <tr>
                                       
                                        <?php 
                                        $NbManche= $match['nbre_manche_tournoi'] ;
                                        for ($I=1;$I<=$NbManche;$I++) { echo '<th class="manche'.$I.'"><button type="button" class="btn btn-block btn-primary"  id="manche'.$I.'j1" value="'.$I.'" > '.$I.' </button></th>'; }
                                        ?>
                                    </tr>
                                    <tr>
                                        
                                        <?php 
                                        for ($I=1;$I<=$NbManche;$I++) {echo '<th class="manche'.$I.'"><button type="button" class="btn btn-block btn-lg point"  id="pointj1m'.$I.'p" ><span class="glyphicon glyphicon-plus"></span> </button></th>'; }
                                        ?>
                                    </tr>
                                    <tr>
                                        <?php 
                                        for ($I=1;$I<=$NbManche;$I++) 
                                        {
                                         
                                            //Controle si la page a était actualisée si actuliser les bouton sont actif           
                                            $req='SELECT * FROM manche where num_manche = "'.$I.'" and id_matchs= "'.$id_match.'"';
                                            $req = $bdd-> query ($req);
                                            $manchej1 = $req ->fetch();
                                            
                                            if ($manchej1["point_j1"] == '')
                                            {
                                                $value1=0;
                                                $actu1=0;
                                            }
                                            else 
                                                {
                                                 $value1=$manchej1["point_j1"];
                                                 $actu1=1;
                                                }
                                            
                                            echo '<th class="manche'.$I.' th_score_match"><input type="text" name="scorej1" id="scorej1m'.$I.'" class="score" value="'.$value1.'" maxlength="2" size="2" readonly="true"/></th>'; } 
                                        ?>
                                    </tr>
                                    <tr>
                                        <?php 
                                        for ($I=1;$I<=$NbManche;$I++) {echo '<th class="manche'.$I.'"><button type="button" class="btn btn-block btn-lg point" id="pointj1m'.$I.'m" ><span class="glyphicon glyphicon-minus"></span></button></th>';}
                                        ?>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>         
            </section><br/>
            
            
            <div id="infoj2" class="row" >
                <div class="col-md-5 col-md-offset-1">    
                    <h4><?=__Nom?> : <?=$match['competiteur2'];?></h4>
                </div>
                <div class="col-md-3 col-md-offset-1">
                    <h4><?=__Num_d?> : <?=$match['dossard_competiteur2'];?></h4>
                </div>
            </div>
            <section id="scorej2">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <table width="100%" class="table-bordered"  >
                                <tbody>
                                    <tr>
                                        
                                        <?php
                                         for ($I=1;$I<=$NbManche;$I++) { echo '<th class="manche'.$I.'"><button type="button" class="btn btn-block btn-primary"  id="manche'.$I.'j2" > '.$I.' </button></th>'; }
                                        ?>
                                    </tr>
                                      
                                    <tr>
                                        
                                        <?php 
                                        for ($I=1;$I<=$NbManche;$I++) {echo '<th class="manche'.$I.'"><button type="button" class="btn btn-block btn-lg point"  id="pointj2m'.$I.'p" ><span class="glyphicon glyphicon-plus"></span> </button></th>'; }
                                        ?>
                                    </tr>
                                    <tr>

                                        <?php 
                                        for ($I=1;$I<=$NbManche;$I++) {
                                            
                                            $req='SELECT * FROM manche where num_manche = "'.$I.'" and id_matchs= "'.$id_match.'"';
                                            $req = $bdd-> query ($req);
                                            $manchej2 = $req ->fetch();
                                            
                                           if ($manchej2["point_j2"] == '')
                                            {
                                                $value2=0;
                                                $actu2=0;
                                            }
                                            else 
                                                {
                                                  $value2=$manchej2["point_j2"];
                                                  $actu2=1;
                                                }
                                            
                                            echo '<th class="manche'.$I.' th_score_match"><input type="text" name="scorej2" id="scorej2m'.$I.'" class="score" value="'.$value2.'" maxlength="2" size="2" readonly="true"/></th>'; } 
                                        ?>
                                    </tr>
                                    <tr>

                                        <?php 
                                        for ($I=1;$I<=$NbManche;$I++) {echo '<th class="manche'.$I.'"><button type="button" class="btn btn-block btn-lg point" id="pointj2m'.$I.'m"  ><span class="glyphicon glyphicon-minus"></span></button></th>';}
                                        ?>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section><br/>
            <section id="faute">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <table widht="100%" class="table-bordered">
                                
                                <tr>
                                    <th class="col-lg-1"><?=__Nom?> </th>
                                    <th class="col-lg-1"><?=__Jaune?> </th>
                                    <th class="col-lg-1"><?=__JR?> </th>
                                    <th class="col-lg-1"><?=__JR2?> </th>
                                    <th class="col-lg-1"><?=__WO?> </th>
                                    <th class="col-lg-1"><?=__TM?> </th>
                                </tr>
                                <tr>
                                    <th class="col-lg-1"><?=__Comp1?> </th>
                                    <th class="col-lg-1"><input type="checkbox" name="Jaunej1" id="check1" class="yellow check" value="<?= $match['faute_cj_j1']; ?> "/></th>
                                    <th class="col-lg-1"><input type="checkbox" name="JR1j1"  id="check2" class="red check" value="<?= $match['faute_cjcr1_j1']; ?> "/></th>
                                    <th class="col-lg-1"><input type="checkbox" name="JR2j1" id="check3" class="red check" value="<?= $match['faute_cjcr2_j1']; ?> "/></th>
                                    <th class="col-lg-1"><input type="checkbox" name="WOj1" id="check4" class="check" value="<?= $match['forfait_j1']; ?> "/></th>
                                    <th class="col-lg-1"><input type="checkbox" name="TMj1" id="check5" class="check" value="<?= $match['temps_mort_j1']; ?> "/></th>
                                </tr>
                                <tr>
                                    <th class="col-lg-1"><?=__Comp2?> </th>
                                    <th class="col-lg-1"><input type="checkbox" name="Jaunej2" id="check6" class="yellow check" value="<?= $match['faute_cj_j2']; ?> " /></th>
                                    <th class="col-lg-1"><input type="checkbox" name="JR1j2" id="check7" class="red check" value="<?= $match['faute_cjcr1_j2']; ?> "/></th>
                                    <th class="col-lg-1"><input type="checkbox" name="JR2j2" id="check8" class="red check" value="<?= $match['faute_cjcr2_j2']; ?> "/></th>
                                    <th class="col-lg-1"><input type="checkbox" name="WOj2" id="check9" class="check" value="<?= $match['forfait_j2']; ?> "/></th>
                                    <th class="col-lg-1"><input type="checkbox" name="TMj2" id="check10" class="check" value="<?= $match['temps_mort_j2']; ?> "/></th>
                                </tr>       
                            </table>
                        </div>
                    </div>
                </div>
            </section><br/>
                <div class="form-group">
                    <button type="button" name="fin_match" id="fin_m" class="btn btn-default" value="fin" ><?=__Fin_m?></button>
                </div>
            <div class="row"> 
                <div class="col-md-2 col-md-offset-5">
                    <a href="selection_match.php" ><?=__Ret_se ?></a>
                </div>
            </div> 
                     
        </div>
        <footer>
            
        </footer>
            <script type="text/javascript" src="/<?=$Rep?>jQuery/jquery-1.11.1.js"></script>
            <script type="text/javascript" src="/<?=$Rep?>bootstrap/dist/js/bootstrap.min.js"></script>
            
            <script>
                $(function()
                {
                    
                    $(document).ready(function(){
                        
                        //desactivation des boutons au chargement de la page, controle si actualisation de la page                         
                        var actu1 = <?= $actu1 ?>;
                        if ( actu1 == 0 )
                        {
                        $('.point').attr("disabled",true);
                        }
                        else
                        {
                            $('.point').attr("disabled",false);
                        }
                        var actu2 = <?= $actu2 ?>;
                        if ( actu2 == 0 )
                        {
                        $('.point').attr("disabled",true);
                        }
                        else
                        {
                            $('.point').attr("disabled",false);
                        }
                                   
                    });
                    
               
                    /*Debut de match enregistrement des infos du match
                    * mise a zero des scores et des checks si active
                    */
                    $('#debut_m').on('click',function()
                    {
                        //mise a zero de tout les score et des checks
                        $('.score').val(0);
                        $('.check').attr("checked",false);
                        //activation des +-
                        $('.point').attr("disabled",false);
                        
                        //recuperation des infos du match 
                        var debut = $('#debut_m').val();
                        var match = <?=$match['id_matchs']?>;
                        var manche = <?=$match['nbre_manche_tournoi'];?> ;  
                        //var table1 = <?=$match['nbre_table_tournoi'];?>;
                        var nomj1 = "<?=$match['competiteur1'];?>";
                        var nomj2 = "<?=$match['competiteur2'];?>";
                        var paysj1= "<?=$match['paysj1'];?>";
                        var paysj2="<?=$match['paysj2'];?>";
                        var table = <?=$match['num_table'];?>;
                        
                  
                        resultat_manchej1=0;
                        resultat_manchej2=0;
                              // nombre de manche gagné
                                for (i = 0; i <= <?=$NbManche?>; i++) 
                                {
                                var SJ1MEC = parseInt($('#scorej1m'+i).val());
                                var SJ2MEC = parseInt($('#scorej2m'+i).val());
                                var DIFFMEC=   Math.abs(SJ2MEC-SJ1MEC);
                                
                                if ((SJ1MEC>10) && (SJ1MEC>SJ2MEC) && (DIFFMEC>1)) 
                                {resultat_manchej1=resultat_manchej1+1;}
                                    if ((SJ2MEC>10) && (SJ2MEC>SJ1MEC) && (DIFFMEC>1)) 
                                    {resultat_manchej2=resultat_manchej2+1;}
                                }
    
                              var res_manchej1= resultat_manchej1;
                              var res_manchej2= resultat_manchej2;
                              
                              //numero de la manche
                              var num_manche=res_manchej1+res_manchej2+1;
                        
                     
                        <?php
                        for ($d=1;$d<=$NbManche;$d++)                    
                        { ?>
                              var scorej1m<?=$d?>  = 0;
                              var scorej2m<?=$d?> = 0;
                       
                           <?php }?> 
                        var statut = 1;
                        var dataString = 'debut='+debut+'&match='+match+'&num_manche='+num_manche+'&nomj1='+nomj1+'&nomj2='+nomj2+'&paysj1='+paysj1+'&paysj2='+paysj2+'&table='+table+'&manche='+manche+'&resj1='+res_manchej1+'&resj2='+res_manchej2+'&statut='+statut<?php for ($b1=1;$b1<=$NbManche;$b1++){?>+'&scorej1m<?=$b1?>='+scorej1m<?=$b1?>+'&scorej2m<?=$b1?>='+scorej2m<?=$b1?> <?php }?> ;
                       // alert (dataString);
                        
                        $.ajax({
                                    type: "POST",
                                    url: "insertion_statut.php",
                                    data: dataString
                                    });
                       
                    });
                 
                    /*Action lors du click a la fin du match
                     * On reccupere toutes les données pour les enregistrers
                     * on change le statut du match 
                     */
                    $('#fin_m').on('click',function()
                    {
                        //message de confirmation de fin de match
                       var alert= confirm('<?=__Alert_fin?>');
                        if(alert== true)
                        {
                        
                        //On reccupere toutes les données pour les enregstrées dans la base une derniere fois
                        var match = <?=$match['id_matchs']?>;
                        var fin = $('#fin_m').val();
                        var table = <?=$match['num_table']; ?>;
                        var check = 'check';
                          
                        <?php
                        $nbcheck=10;
                        for ($I=1;$I<=$nbcheck;$I++)                    
                        { ?>
                        
                            var check<?=$I?> = parseInt($('#check<?=$I?>').val());
                            <?php }?>   
                                
                            //info du joueur et du match                          
                              var manches = <?=$match['nbre_manche_tournoi'];?> ;  
                              var num_manche= parseInt($('#manche<?=$I?>j1').val());
                              var nomj1 = "<?=$match['competiteur1'];?>";
                              var nomj2 = "<?=$match['competiteur2'];?>";
                              var paysj1= "<?=$match['paysj1'];?>";
                              var paysj2="<?=$match['paysj2'];?>";
                              
                               
                               resultat_manchej1=0;
                               resultat_manchej2=0;
                               
                                // nombre de manche gagné
                                for (i = 0; i <= <?=$NbManche?>; i++) 
                                {
                                    var SJ1MEC = parseInt($('#scorej1m'+i).val());
                                    var SJ2MEC = parseInt($('#scorej2m'+i).val());
                                    var DIFFMEC=   Math.abs(SJ2MEC-SJ1MEC);
                                    if ((SJ1MEC>10) && (SJ1MEC>SJ2MEC) && (DIFFMEC>1)) {resultat_manchej1=resultat_manchej1+1;}
                                    if ((SJ2MEC>10) && (SJ2MEC>SJ1MEC) && (DIFFMEC>1)) {resultat_manchej2=resultat_manchej2+1;}
                                }
    
                              var res_manchej1= resultat_manchej1;
                              var res_manchej2= resultat_manchej2;
                              
                              //numero de la manche
                              var num_manche=res_manchej1+res_manchej2+1;
                                                        
                              //score
                              <?php
                        for ($d=1;$d<=$NbManche;$d++)                    
                        { ?>
                              var scorej1m<?=$d?>  = parseInt($('#scorej1m<?=$d?> ').val());
                              var scorej2m<?=$d?> = parseInt($('#scorej2m<?=$d?> ').val());
                                
                           <?php }?>     

                            var dataString = 'manche='+num_manche+'&fin='+fin+'&match='+match+'&jaunej1='+check1+'&jr1j1='+check2+'&jr2j1='+check3+'&woj1='+check4+'&tmj1='+check5+'&jaunej2='+check6+'&jr1j2='+check7+'&jr2j2='+check8+'&woj2='+check9+'&tmj2='+check10+'&check='+check+'&manche='+manches+'&nomj1='+nomj1+'&nomj2='+nomj2+'&paysj1='+paysj1+'&paysj2='+paysj2+'&resj1='+res_manchej1+'&resj2='+res_manchej2+'&num_manche='+num_manche+'&table='+table<?php for ($b=1;$b<=$NbManche;$b++){?>+'&scorej1m<?=$b?>='+scorej1m<?=$b?>+'&scorej2m<?=$b?>='+scorej2m<?=$b?> <?php }?> ;
                         
                        $.ajax({
                                    type: "POST",
                                    url: "insertion_fin.php",
                                    data: dataString
                                    });
                                    
                                    
                     //redirection vers la page de selection des matchs
                     document.location.href="selection_match.php"; 
                                    
                    }
                    else
                    {
                        alert('<?=__Alert_false?>');
                    }
    
                    });
                    
                    /*Comptage des points points des deux joueurs
                     * ajout et suppression des point en cas d'erreur
                     */
                    
               
                    //comptage des point du joueur 1
                     <?php
                        for ($I=1;$I<=$NbManche;$I++)                    
                        { ?> 
                    
                    var pointj1m<?=$I?>= parseInt($('#scorej1m<?=$I?>').val());	
                    
            
                    //ajout point au click
                    $('#pointj1m<?=$I?>p').on('click',function()
			{
 
                            pointj1m<?=$I?> = pointj1m<?=$I?> + 1;
                            $('#scorej1m<?=$I?>').val(pointj1m<?=$I?>);
                         
                        });
                    //suppression point    
                    $('#pointj1m<?=$I?>m').on('click',function()
			{
                            pointj1m<?=$I?> = pointj1m<?=$I?> - 1;
                            $('#scorej1m<?=$I?>').val(pointj1m<?=$I?>);
				
			if (pointj1m<?=$I?> == 0)
                            {
                                alert('le joueur 1 a 0 point');
                            }
                        });
                        
                     <?php }?>  
                     
                     
                     //comptage des points du joueur 2
                    <?php
                        for ($I=1;$I<=$NbManche;$I++)                    
                        { ?> 
                    
                    var pointj2m<?=$I?>= parseInt($('#scorej2m<?=$I?>').val());	
                 
               
                    
                    //ajout point
                    $('#pointj2m<?=$I?>p').on('click',function()
			{
                            //calcul des points
                            pointj2m<?=$I?> = pointj2m<?=$I?> + 1;
                            $('#scorej2m<?=$I?>').val(pointj2m<?=$I?>);
                           
                        });
                    //suppression point    
                    $('#pointj2m<?=$I?>m').on('click',function()
			{
                            pointj2m<?=$I?> = pointj2m<?=$I?> - 1;
                            $('#scorej2m<?=$I?>').val(pointj2m<?=$I?>);
				
			if (pointj2m<?=$I?> == 0)
                            {
                                alert('le joueur 2 a 0 point');
                            }
                        });
                        <?php }?> 
                        
                        
                    /*Gestion des chexks box pour les cartons
                     * valeur 1 si active sinon 0
                     * 
                     */    
                 
                    $('.check').on('click',function()
                           {
                               <?php
                               $nbcheck=10;
                               for ($I=1;$I<=$nbcheck;$I++)                    
                                { ?>
                            if($('#check<?=$I?>').is(':checked') )
                               {
                                $('#check<?=$I?>').val(1);
                                //alert('check');  
                                } 
                                else 
                                {
                                $('#check<?=$I?>').val(0);
                               // alert('no check');
                                }
                                <?php }?>
                            });
                            
                            //valeur checkboxs sauvegarder en cas de probleme page
                            $( document ).ready(function() 
                            {
                              
                                <?php
                               $nbcheck=10;
                               for ($I=1;$I<=$nbcheck;$I++)                    
                                { ?>
                                 var value =  parseInt($('#check<?=$I?>').val() ) ;       
                            if( value == 1)
                               {
                                $('#check<?=$I?>').attr("checked",true);
                                
                                } 
                              
                                <?php }?>


                            });
                        /*Sauvegarde des checkboxs dans la base de donnée
                         * 
                         */
                        $( ".check" ).on( "click", function () 
                           {
                               var table = <?=$match['num_table']; ?>;
                               var match = <?=$match['id_matchs']?>;
                               var check = 'check';
                          <?php
                         $nbcheck=10;
                        for ($I=1;$I<=$nbcheck;$I++)                    
                        { ?>
                        
                            var check<?=$I?> = parseInt($('#check<?=$I?>').val());
                            <?php }?>                      
                            var dataString = 'jaunej1='+check1+'&jr1j1='+check2+'&jr2j1='+check3+'&woj1='+check4+'&tmj1='+check5+'&jaunej2='+check6+'&jr1j2='+check7+'&jr2j2='+check8+'&woj2='+check9+'&tmj2='+check10+'&match='+match+'&check='+check+'&table='+table;
                            
                            
                            //Insertion dans la base et dans le fichier Json
                            //alert(dataString);
                            $.ajax({
                                    type: "POST",
                                    url: "insertion_match.php",
                                    data: dataString
                                    });
                       
                            
                        });
                        
                        
                       //enregistrement dans fichier jSON des point et des scores
                          $('.point').on('click',function()  
                          {
                              //info du joueur et du match
                              var matchs = <?=$match['id_matchs'];?>;
                              var manches = <?=$match['nbre_manche_tournoi'];?> ;  
                              var table = <?=$match['num_table'];?>;
                              var nomj1 = "<?=$match['competiteur1'];?>";
                              var nomj2 = "<?=$match['competiteur2'];?>";
                              var paysj1= "<?=$match['paysj1'];?>";
                              var paysj2="<?=$match['paysj2'];?>";
                               
                               
                               //calcule du nombre de manche gagner
                               resultat_manchej1=0;
                               resultat_manchej2=0;
                              // nombre de manche gagné
                              for (i = 0; i <= <?=$NbManche?>; i++) {
                                var SJ1MEC = parseInt($('#scorej1m'+i).val());
                                var SJ2MEC = parseInt($('#scorej2m'+i).val());
                                var DIFFMEC=   Math.abs(SJ2MEC-SJ1MEC);
                              
                                
                                if ((SJ1MEC>10) && (SJ1MEC>SJ2MEC) && (DIFFMEC>1)) {resultat_manchej1=resultat_manchej1+1;}
                                if ((SJ2MEC>10) && (SJ2MEC>SJ1MEC) && (DIFFMEC>1)) {resultat_manchej2=resultat_manchej2+1;}
                      
                            
                            }
    
                              var res_manchej1= resultat_manchej1;
                              var res_manchej2= resultat_manchej2;
                              
                              //numero de la manche
                              var num_manche=res_manchej1+res_manchej2+1;
                             // alert ('le num manche est '+num_manche);
                              
                              
                              //score
                              <?php
                        for ($d=1;$d<=$NbManche;$d++)                    
                        { ?>
                              var scorej1m<?=$d?>  = parseInt($('#scorej1m<?=$d?> ').val());
                              var scorej2m<?=$d?> = parseInt($('#scorej2m<?=$d?> ').val());
                                                    
                              
                           <?php }?>   
                                 
                              //enregistrement dans la variable data 
                              var dataString = 'match='+matchs+'&manche='+manches+'&nomj1='+nomj1+'&nomj2='+nomj2+'&paysj1='+paysj1+'&paysj2='+paysj2+'&resj1='+res_manchej1+'&resj2='+res_manchej2+'&num_manche='+num_manche+'&table='+table<?php for ($b=1;$b<=$NbManche;$b++){?>+'&scorej1m<?=$b?>='+scorej1m<?=$b?>+'&scorej2m<?=$b?>='+scorej2m<?=$b?> <?php }?> ;               
           

                              //alert (dataString);
                              
                              $.ajax({
                                    type: "POST",
                                    url: "AjaxLoadScore.php",
                                    data: dataString
                                    });
                           
                            });

                        //insertion des points dans la base de donnée avec Ajax
                         <?php
                        for ($I=1;$I<=$NbManche;$I++)                    
                        { ?>
                           $('.point').on('click',function()  
                           {
                            //enregistrement des variables
                            var match = <?=$match['id_matchs']?>;
                            var manche= parseInt($('#manche<?=$I?>j1').val());
                            var scorej1m<?=$I?> = parseInt($('#scorej1m<?=$I?>').val());
                            var scorej2m<?=$I?>  = parseInt($('#scorej2m<?=$I?>').val());
                            var debut =1;
                            var fin =0;
                            

                            var dataString = 'manche='+manche+'&scorej1m<?=$I?>='+scorej1m<?=$I?>+'&scorej2m<?=$I?>='+scorej2m<?=$I?>+'&debut='+debut+'&fin='+fin+'&matchs='+match;
                           
                            $.ajax({
                                    type: "POST",
                                    url: "insertion_score.php",
                                    data: dataString
                                    });

                         });
                        <?php }?>
                        
                        

                    
        });
            </script>
    </body>
</html>

