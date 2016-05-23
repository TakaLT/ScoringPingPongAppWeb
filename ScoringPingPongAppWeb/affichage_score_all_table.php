<?php
// On démarre la session  et on inclut le fichier conf
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
        <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" >
        <meta http-equiv="Pragma" content="no-cache" >
        <meta http-equiv="Expires" content="0" >
        
        <link href="/<?=$Rep?>bootstrap/dist/css/bootstrap.css" rel="stylesheet" type="text/css">
        <link href="/<?=$Rep?>bootstrap/dist/css/bootstrap-theme.css" rel="stylesheet" type="text/css">
        <link href="/<?=$Rep?>module_jquery/bxslider/jquery.bxslider.css" rel="stylesheet" type="text/css">
        <link href="/<?=$Rep?>CSS/style.css" rel="stylesheet" type="text/css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        <title>affichage all</title>
    </head>
    <body class="scoll body_affichage" >
    
        <?php
        //on reccupere les info du tournoi pour l'affichage
        $json = file_get_contents("Tmp/InfoTournoi.json");

        $parsed_json = json_decode($json, $assoc = true );
        $nbretable=$parsed_json['table'];
        $sponsor=$parsed_json['sponsor'];
        
        //recuperation du thème
        $theme=$parsed_json['theme'];
        if ($theme != 1 )
        {
            $fond=$parsed_json['cou_fond'];
            $text=$parsed_json['cou_text'];
            $taille=$parsed_json['taille'];
            $gras=$parsed_json['gras'];
            $style=$parsed_json['style'];
        }
        else 
        {
            $fond='';
            $text='';
            $taille=0;
            $gras=0;
            $style='';    
        }
        
        //Recuperation du nombre de manche
        $NbManche=$parsed_json['manche'];

        ?>

        <div class=" affichage">
  
                    <div class="slider8">
                      
                    <?php
                    for ($t1=1;$t1<=$nbretable;$t1++) 
                    {
                    ?>
                    
                    <div class="slide">
                        
                        <table  class="table-bordered " id="affichage_all">
                            <tbody>
                                <tr>
                                    <td rowspan="2" class="td_table ">
                                        <p class="table">T <?=$t1?></p>
                                    </td>
                                    <td rowspan="2" class="td_com T<?=$t1?>td_com">
                                        <p class="com_att"><?=__Mess_all ?></p>
                                    </td>
                                    <td class="td_nom T<?=$t1?>td_comj1" >
                                        <p  class="nom T<?=$t1?>nomj1"></p>
                                    </td>
                                    <td class="td_pays">
                                        <p  class="pays T<?=$t1?>paysj1">  </p>
                                    </td>
                                        <?php 
                                       
                                        for ($m1=1;$m1<=$NbManche;$m1++) 
                                        {
                                            echo '<td class="td_score  affiche_manche'.$m1.'"><p class="score T'.$t1.'J1M'.$m1.'" >  </p> </td>'; } 
                                        ?>
                                     <td class="td_manche" >
                                         <p class="res_manche T<?=$t1?>manchej1"></p>
                                    </td>
                                    
                                </tr>
                                <tr>
                                    <td class="td_nom T<?=$t1?>td_comj2">
                                        <p class="nom T<?=$t1?>nomj2"></p>
                                    </td>
                                    <td class="td_pays">
                                        <span  class="pays T<?=$t1?>paysj2"></span>
                                    </td>
                                    <?php 
                                        
                                        for ($m2=1;$m2<=$NbManche;$m2++) 
                                        {
                                            echo '<td class=" td_score  affiche_manche'.$m2.'"><p class="score T'.$t1.'J2M'.$m2.'" >  </p> </td>'; } 
                                        ?>
                                    <td class="td_manche" >
                                        <p class="res_manche T<?=$t1?>manchej2"></p>
                                    </td>
                                </tr>     
                            </tbody>
                        </table>
                        
                    </div>
                    <?php } ?>  
                </div>
                   
                
                <footer class="affichage_footer">
                    <div>
                        <span id="sponsor"></span>
                    </div>
                </footer>          
         
        </div>
        <script type="text/javascript" src="/<?=$Rep?>jQuery/jquery-1.11.1.js"></script>
        <script type="text/javascript" src="/<?=$Rep?>bootstrap/dist/js/bootstrap.min.js"></script>        
        <script type="text/javascript" src="/<?=$Rep?>module_jquery/bxslider/jquery.bxslider.js"></script>
        <script type="text/javascript" src="/<?=$Rep?>module_jquery/bxslider/jquery.bxslider.min.js"></script>
        <script type="text/javascript" src="/<?=$Rep?>module_jquery/bxslider/plugins/jquery.easing.1.3.js"></script>
     
        
       <script>   
        $(function() {   
            $(document).ready(function(){
                
            //mise place du slider                        
             $('.slider8').bxSlider({
              mode: 'vertical',
              minSlides: 2,
              slideMargin: 5,
              auto: true,
              controls: false,
              pager: false,
              pause: 10000,
              moveSlides: 2

            });

            //affichage du sponsor
           $('#sponsor').html('<img src="sponsor/<?=$sponsor?>" class="sponsor" alt="Sponsor">');
           
           //changement du theme
           if (<?=$theme?> != 1 )
           {
                $('.body_affichage').css('background-color','<?=$fond?>');
                $('.bx-viewport ').css('background-color','<?=$fond?>');
                $('.body_affichage').css('color','<?=$text?>');
                $('.nom').css('font-size',<?=$taille?>);
                $('.nom').css('font-family','<?=$style?>');
                if (<?=$gras?> == 1)
                {
                    $('.nom').css('font-weight','bold');
                }
           }
           
          Rafraichir_info();

          });
                
             //rafraichissement des infos
            setInterval("Rafraichir_info()", 2000);
             
             //rafraichissement des scores
            setInterval("Rafraichir_score()",2000);
            
        });
                 resultat_manchej1=0;
                var mesScores=new Array();
                
        function Rafraichir_info(){
        <?php 
            for ($r2=1;$r2<=$nbretable;$r2++) { ?>
                $.ajax( {
                type: "GET",
                url : "Tmp/Table<?=$r2?>.json",
                dataType: 'json' }).done(function(data){
                mesScores=eval(data);
                
                    if (mesScores['statut'] != 5  )
                {
                     //ajout des noms                  
                     $('.T<?=$r2?>nomj1').html(mesScores['nomj1']);
                     $('.T<?=$r2?>nomj2').html(mesScores['nomj2']);
                     
                    //ajout des pays
                    //affichage drapeau     
                    var paysj1 = mesScores['paysj1'];
                    var paysj2 = mesScores['paysj2'];                      
                   
                    $('.T<?=$r2?>paysj1').html('<img src="images/drapeaux/'+paysj1+'.jpeg" >');
                    $('.T<?=$r2?>paysj2').html('<img src="images/drapeaux/'+paysj2+'.jpeg" >');
                    
                    
                   //cache du commentaire en attente
                   $('.T<?=$r2?>td_comj1').show();
                   $('.T<?=$r2?>td_comj2').show();
                   $('.T<?=$r2?>td_com').hide();
                }
               
               if (mesScores['statut'] == 5  )
                {
                    //gestion des differents elements lorqu'il n'y a pas de match
                    $('.T<?=$r2?>paysj1').html('<span></span>');
                    $('.T<?=$r2?>paysj2').html('<span></span>');
                    $('.T<?=$r2?>td_comj1').hide();
                    $('.T<?=$r2?>td_comj2').hide();
                    $('.T<?=$r2?>td_com').show();
                    
                }
                      
            });
                
              <?php } ?>   
        
    };
                
        function Rafraichir_score() {
            
            <?php 
            for ($r=1;$r<=$nbretable;$r++) { ?>
                $.ajax( {
                type: "GET",
                url : "Tmp/Table<?=$r?>.json",
                dataType: 'json' }).done(function(data){
                mesScores=eval(data);
                
                <?php for ($I=1;$I<=$NbManche;$I++) { ?>
                    //affichage des score
                    $('.T<?=$r?>J1M<?=$I?>').html(mesScores['scorej1m<?=$I?>']);
                    $('.T<?=$r?>J2M<?=$I?>').html(mesScores['scorej2m<?=$I?>']);
                     
                     //cacher resultat si valeur 0 sinon on affiche resultat
                     //joueur 1
                    if (mesScores['scorej1m<?=$I?>'] == 0 )
                    {
                        $('.T<?=$r?>J1M<?=$I?>').hide();
                    }
                    else
                    {
                        $('.T<?=$r?>J1M<?=$I?>').show(); 
                    }
                    //joueur 2
                    if (mesScores['scorej2m<?=$I?>'] == 0)
                    {
                        $('.T<?=$r?>J2M<?=$I?>').hide();
                    }
                    else
                    {
                        $('.T<?=$r?>J2M<?=$I?>').show(); 
                    }
                    
                    //affiche le score zero lorsque l'on change de manche 
                    if (mesScores['num_manche'] >=1)
                    {
                        if ((mesScores['scorej1m<?=$I?>'] != 0 ) || (mesScores['scorej2m<?=$I?>'] !=0 ))
                        {
                           //alert ('le numero de la manche est '+mesScores['num_manche']); 
                           for (s= 1; s<= mesScores['num_manche']; s++) 
                           {
                               $('.T<?=$r?>J1M'+s).show();
                               $('.T<?=$r?>J2M'+s).show();
                           }
                        }
                    }
                    
                    //calcul de manche gagné
                    $('.T<?=$r?>manchej1').html(mesScores['resj1']);
                    $('.T<?=$r?>manchej2').html(mesScores['resj2']);

                <?php } ?>              
                });
                
              <?php } ?>     
            };   
        </script>
            
    </body>
</html>
