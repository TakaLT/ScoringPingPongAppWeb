<?php
include 'connexion.php';
include_once('lang/lang_conf.php');

if($_POST)
{
    //recuperation des variables
    $jaunej1 = $_POST['jaunej1'];
    $jaunej2 = $_POST['jaunej2'];
    $jr1j1 = $_POST['jr1j1'];
    $jr1j2 =$_POST['jr1j2'];
    $jr2j1 =$_POST['jr2j1'];
    $jr2j2 =$_POST['jr2j2'];
    $woj1 =$_POST['woj1'];
    $woj2 =$_POST['woj2'];
    $tmj1 =$_POST['tmj1'];
    $tmj2 =$_POST['tmj2'];
    $match=$_POST['match'];
    $table=$_POST['table'];


    $req="UPDATE matchs SET temps_mort_j1= :tmj1 , temps_mort_j2= :tmj2, faute_cj_j1= :jaunej1, faute_cj_j2= :jaunej2, faute_cjcr1_j1= :jr1j1, faute_cjcr1_j2= :jr1j2, faute_cjcr2_j1= :jr2j1, faute_cjcr2_j2= :jr2j2, forfait_j1= :woj1, forfait_j2= :woj2 WHERE id_matchs = :id_matchs";
    $req_update= $bdd ->prepare($req);
    $req_update->execute (array('tmj1'=>$tmj1,'tmj2'=>$tmj2, 'jaunej1'=>$jaunej1,'jaunej2'=>$jaunej2,'jr1j1'=>$jr1j1,'jr1j2'=>$jr1j2, 'jr2j1'=>$jr2j1,'jr2j2'=>$jr2j2,'woj1'=>$woj1,'woj2'=>$woj2, 'id_matchs'=>$match ));


    //creation du fichier Json pour la gestion des faute
    $Tab['match']=$match;
    $Tab['jaunej1']=$jaunej1;
    $Tab['jaunej2']=$jaunej2;
    $Tab['jr1j1']=$jr1j1;
    $Tab['jr1j2']=$jr1j2;
    $Tab['jr2j1']=$jr2j1;
    $Tab['jr2j2']=$jr2j2;
    $Tab['woj1']=$woj1;
    $Tab['woj2']=$woj2;
    $Tab['tmj1']=$tmj1;
    $Tab['tmj2']=$tmj2;
    $Tab['table']=$table;    
  
    $strsortie = json_encode( $Tab );    
    $fic=fopen('tmp/carton_table'.$table.'.json','w');
    fwrite($fic, $strsortie);
    fclose($fic);
    
    //Envoi sur serveur externe    
    $strsortieB64=  base64_encode($strsortie);
    $Param='table='.$table.'&strcarton='.$strsortieB64;
    $ch = curl_init();  
    $url= $Url_public.'jsonWritecarton.php';
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_HEADER, false); 
    curl_setopt($ch, CURLOPT_POST, count($Param));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $Param);    

    $output=curl_exec($ch);
    //echo $output;
    curl_close($ch);

}
