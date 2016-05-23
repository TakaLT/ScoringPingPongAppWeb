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
        <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" >
        <meta http-equiv="Pragma" content="no-cache" >
        <meta http-equiv="Expires" content="0" >
        
        <link href="/<?=$Rep?>bootstrap/dist/css/bootstrap.css" rel="stylesheet" type="text/css">
        <link href="/<?=$Rep?>bootstrap/dist/css/bootstrap-theme.css" rel="stylesheet" type="text/css">
        <link href="/<?=$Rep?>CSS/style.css" rel="stylesheet" type="text/css">
        <title>affichage one</title>
    </head>
    <body class="scoll body_affichage">
        <?php
       // indication du chemin du fichier Json et recuperation des infos
        $json = file_get_contents("Tmp/InfoTournoi.json");
        $parsed_json = json_decode($json, $assoc = true );
        
        $nbretable=$parsed_json['table'];
        $sponsor=$parsed_json['sponsor'];
        $NbManche=$parsed_json['manche'];

        //recuperation des parametres du thème
        $theme=$parsed_json['theme'];
        if ($theme != '1' )
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

            $table=$_GET['table'];
          
        ?>
        <div class="affichage">
            <div class="row">
                <div class="col-lg-12">
                    <header class="">
                    <div>
                        <span></span>
                    </div>
                    </header>
                    <table class="table-bordered" id="affichage_one">
                        <tbody>
                            <tr class="tr_com">
                                 <td colspan="4" id="td_com" class="td_com">
                                     <p class="com_att"><?=__Mess_one ?></p>
                                 </td>
                            </tr>
                            <tr class="tr_nom">
                                 <td colspan="2" id="td_nom" class="td_nom">
                                     <span id="nomj1" class="nom_table archive"></span>
                                </td>
                                <td colspan="2" class="td_nom">
                                    <span id="nomj2" class="nom_table archive"></span>
                                </td>
                            </tr>
                            <tr class="tr_pays_manche">
                                <td class="td_pays">
                                    <span id="paysj1" class="pays_table archive "></span>
                                </td>
                                <td class="td_manche">
                                    <span id="manchej1" class="manche_table archive score"></span>
                                </td>
                                <td class="td_manche">
                                    <span id="manchej2" class="manche_table archive score"></span>
                                </td>
                                <td class="td_pays">
                                    <span id="paysj2" class="pays_table archive "></span>
                                </td>
                            </tr>
                           
                            <tr class="tr_faute_score">
                                <td class="td_faute">
                                    <span class="faute_table archive score"><img src="images/carton/Jaune.png" class="carton" id="jaunej1"><img src="images/carton/JR1.png" class="carton" id="jr1j1"><img src="images/carton/JR2.png" class="carton" id="jr2j1"></span>
                                </td>
                                <td rowspan="2" class="td_score">
                                    <span id="scorej1" class="score_table archive score"></span>
                                </td>
                                <td rowspan="2" class="td_score">
                                    <span id="scorej2" class="score_table archive score"></span>
                                </td>
                                <td class="td_faute">
                                    <span class="faute_table archive score"><img src="images/carton/Jaune.png" class="carton" id="jaunej2"><img src="images/carton/JR1.png" class="carton" id="jr1j2"><img src="images/carton/JR2.png" class="carton" id="jr2j2"></span>
                                </td>
                            </tr>
                            <tr class="tr_tm_score">
                                <td class="td_tm">
                                    <span class="tm_table archive score"><img src="images/carton/WO.png" class="carton" id="woj1"><img src="images/carton/TM.png" class="carton" id="tmj1"></span>
                                </td>
                                <td class="td_tm">
                                    <span class="tm_table archive score"><img src="images/carton/WO.png" class="carton" id="woj2"><img src="images/carton/TM.png" class="carton" id="tmj2"></span>
                                </td>
                              
                            </tr>

                        </tbody>
                    </table>
                    <footer class="affichage_footer">
                    <div>
                        <span id="sponsor"></span>
                    </div>
                </footer>
                </div>
            </div>
        </div> 
        <script type="text/javascript" src="/<?=$Rep?>jQuery/jquery-1.11.1.js"></script>
        <script type="text/javascript" src="/<?=$Rep?>bootstrap/dist/js/bootstrap.min.js"></script>
        <script type="text/javascript">
            $(function() { 
                //On cache les carton au après chargement de la page
                $('.carton').hide();
                
                $(document).ready(function(){
               
            
           //affichage du sponsor
           $('#sponsor').html('<img src="sponsor/<?=$sponsor?>" class="sponsor">');
           
           //changement du theme
           if (<?=$theme?> != 1 )
           {
                $('.body_affichage').css('background-color','<?=$fond?>');
                $('.body_affichage').css('color','<?=$text?>');
                $('.nom_table').css('font-size',<?=$taille?>);
                $('.nom_table').css('font-family','<?=$style?>');
                if (<?=$gras?> == 1)
                {
                    $('.nom_table').css('font-weight','bold');
                }
            }
            
            Rafraichir_info();
            Rafraichir_score();
            Rafraichir_carton();
                        
            });
        
             //rafraichissement des infos
            setInterval("Rafraichir_info()", 5000);
             
             //rafraichissement des scores
            setInterval("Rafraichir_score()",1000);
            
              //rafraichissement des scores
            setInterval("Rafraichir_carton()",1000);

               });
            
            var mesScores=new Array();
            function Rafraichir_info(){
        
                $.ajax( {
                type: "GET",
                url : "Tmp/Table<?=$table?>.json",
                dataType: 'json' }).done(function(data){
                mesScores=eval(data);
                
                if (mesScores['statut'] != 5  )
                {
                    //ajout des noms                  
                    $('#nomj1').html(mesScores['nomj1']);
                    $('#nomj2').html(mesScores['nomj2']);
                    //ajout des pays
                    //affichage drapeau     
                      var paysj1 = mesScores['paysj1'];
                      var paysj2 = mesScores['paysj2'];
                      
                      
                    $('#paysj1').html('<img src="images/drapeaux/'+paysj1+'.jpeg" >');
                    $('#paysj2').html('<img src="images/drapeaux/'+paysj2+'.jpeg" >');
    
                    //Cache du commentaire de match en attente
                    $('.tr_com').hide();
                    $('.tr_nom').show();                    
                    
                }
                else
                {
                    $('.archive').hide();
                    $('.tr_com').show();
                    $('.tr_nom').hide();
  
                }
                
                if (mesScores['statut'] == 2  )
                {
                    $('.archive').show();
                    $('.score').hide();
                    
                }
                
                if (mesScores['statut'] == 1  )
                {
                    $('.score').show();                   
                }
                
                    
                     });
                     };
    
            function Rafraichir_score() {
   
          
                $.ajax( {
                type: "GET",
                url : "Tmp/Table<?=$table?>.json",
                dataType: 'json' }).done(function(data){
                mesScores=eval(data);
                
                var num_manche= mesScores['num_manche'];
                    
                    if (mesScores['statut'] != 5  )
                    {
                        if(mesScores['num_manche'] > <?=$NbManche?>)
                        {
                            //affichage du score 
                            $('#scorej1').html(mesScores['scorej1m'+(num_manche-1)]);
                            $('#scorej2').html(mesScores['scorej2m'+(num_manche-1)]);
                     
                            //affichage manche
                            $('#manchej1').html(mesScores['resj1']);
                            $('#manchej2').html(mesScores['resj2']);
                        }
                        else
                        {
                            //affichage du score pour la derniere manche
                            $('#scorej1').html(mesScores['scorej1m'+num_manche]);
                            $('#scorej2').html(mesScores['scorej2m'+num_manche]);
                        
                            //calcul de manche gagné
                            $('#manchej1').html(mesScores['resj1']);
                            $('#manchej2').html(mesScores['resj2']);
                        }
                    }
                    else
                    {
                        $('.archive').hide();
                    }
                
                if (mesScores['statut'] == 2  )
                {
                    $('.archive').show();
                    $('.score').hide();                    
                }
                
                if (mesScores['statut'] == 1  )
                {
                    $('.score').show();                    
                }
            
                });
            };
                 
                var cartons=new Array();
                function Rafraichir_carton() {
   
          
                $.ajax( {
                type: "GET",
                url : "Tmp/carton_table<?=$table?>.json",
                dataType: 'json' }).done(function(data){
                cartons=eval(data);
              
              //Gestion des cartons
              //affichage du carton jaune              
              if (cartons['jaunej1'] ==1 )
              {
                  $('#jaunej1').show();
              }
              else
              {
               $('#jaunej1').hide();   
              }
              if (cartons['jaunej2'] ==1 )
              {
                  $('#jaunej2').show();
              }
              else
              {
               $('#jaunej2').hide();   
              }
              
              //Carton rouge jaune 1
              if (cartons['jr1j1'] ==1 )
              {
                  $('#jr1j1').show();
              }
              else
              {
               $('#jr1j1').hide();   
              }
              if (cartons['jr1j2'] ==1 )
              {
                  $('#jr1j2').show();
              }
              else
              {
               $('#jr1j2').hide();   
              }
              
              //Carton rouge jaune 2
              if (cartons['jr2j1'] ==1 )
              {
                  $('#jr2j1').show();
              }
              else
              {
               $('#jr2j1').hide();   
              }
              if (cartons['jr2j2'] ==1 )
              {
                  $('#jr2j2').show();
              }
              else
              {
               $('#jr2j2').hide();   
              }
              
              //Carton WO
              if (cartons['woj1'] ==1 )
              {
                  $('#woj1').show();
              }
              else
              {
               $('#woj1').hide();   
              }
              if (cartons['woj2'] ==1 )
              {
                  $('#woj2').show();
              }
              else
              {
               $('#woj2').hide();   
              }
              
              //carton TM
              if (cartons['tmj1'] ==1 )
              {
                  $('#tmj1').show();
              }
              else
              {
               $('#tmj1').hide();   
              }
              if (cartons['tmj2'] ==1 )
              {
                  $('#tmj2').show();
              }
              else
              {
               $('#tmj2').hide();   
              }
              
                });
            };
               
        </script>
            
        
    </body>
</html>
