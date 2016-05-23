<?php
include_once('lang/lang_conf.php');

if($_POST)
{
    //Reccuperation des variables pour créer le Json avec les scores et les infos des joueurs
    $manche = $_POST['manche'];
    $match = $_POST['match'];
    $nomj1 = $_POST['nomj1'];
    $nomj2 = $_POST['nomj2'];
    $paysj1 =$_POST['paysj1'];
    $paysj2 =$_POST['paysj2'];
    $table =$_POST['table'];
    $resj1 = $_POST['resj1'];
    $resj2 = $_POST['resj2'];
    $num_manche=$_POST['num_manche'];
    $statut=1;

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
    $Tab['num_manche']=$num_manche;
    $Tab['statut']=$statut;
     
    //creation du Json
    $strsortie = json_encode( $Tab );    
    $fic=fopen('tmp/Table'.$table.'.json','w');
    fwrite($fic, $strsortie);
    fclose($fic);
        
    // Copie du fichier Json score sur une url externe pour envoie score sur le serveur publique
    
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