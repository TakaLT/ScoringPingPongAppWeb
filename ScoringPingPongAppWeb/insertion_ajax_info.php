<?php
//reccuperation info 
$match =  $_POST['match'];             
$nomj1 =  $_POST['nomj1'];
$nomj2 = $_POST['nomj2']; 
$paysj1 =  $_POST['paysj1'];
$paysj2 = $_POST['paysj2']; 
$table = $_POST['num_table']; 
$statut= $_POST['statut'];

//enregistrement dans un tableau
$Tab['match']=$match;
$Tab['nomj1']=$nomj1;
$Tab['nomj2']=$nomj2;
$Tab['paysj1']=$paysj1;
$Tab['paysj2']=$paysj2;
$Tab['table']=$table;

//enregistrement dans le Json  
$strsortie = json_encode( $Tab );    
$fic=fopen('tmp/Table'.$table.'.json','w');
fwrite($fic, $strsortie);
fclose($fic);