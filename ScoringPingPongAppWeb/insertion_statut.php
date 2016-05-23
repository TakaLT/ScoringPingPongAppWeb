<?php

include 'connexion.php';
include_once('lang/lang_conf.php');

//enregistre variable
$match=$_POST['match'];

if( $_POST['debut'])
    
   {    
        //enregistrement des variables
        $manche = $_POST['manche'];
        $match = $_POST['match'];
        $nomj1 = $_POST['nomj1'];
        $nomj2 = $_POST['nomj2'];
        $paysj1 =$_POST['paysj1'];
        $paysj2 =$_POST['paysj2'];
        $table = $_POST['table'];
        $resj1 = $_POST['resj1'];
        $resj2 = $_POST['resj2'];
        $statut= $_POST['statut'];
        $num_manche=$_POST['num_manche'];            
        
        $NbManche=$manche;
         
            for ($e=1;$e<=$NbManche;$e++)
            {

            $Tab["scorej1m$e"]= $_POST['scorej1m'.$e];
            $Tab["scorej2m$e"]= $_POST['scorej2m'.$e];
            }
            $Tab['match']=$match;
            $Tab['manche']=$manche;
            $Tab['nomj1']=$nomj1;
            $Tab['nomj2']=$nomj2;
            $Tab['paysj1']=$paysj1;
            $Tab['paysj2']=$paysj2;
            $Tab['table']=$table;
            $Tab['resj1']=$resj1;
            $Tab['resj2']=$resj2;
            $Tab['statut']=$statut;
            $Tab['num_manche']=$num_manche;


            //Creation Json
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
      
            //Mise a jour de la base de donnée
            $req="UPDATE matchs SET id_statut= :statut   WHERE id_matchs = :id_match";
            $req_update1= $bdd ->prepare($req);
            $req_update1->execute (array('statut'=>1,'id_match'=>$match ));
        
   }
   
