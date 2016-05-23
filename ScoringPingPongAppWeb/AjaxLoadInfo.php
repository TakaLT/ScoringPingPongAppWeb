<?php
if($_POST)
{
    //Recuperation des variables pour crée le Json avec les informations du tournoi
    $manche = $_POST['manche'];
    $match = $_POST['match'];
    $sponsor =$_POST['sponsor'];
    //remplacement du caractere + qui se trouve dans le nom des images
    $sponsor = str_replace("ZzZzZz", "+", $sponsor);
    
    //enregistrement dans un tableau
    $table =$_POST['table'];
    $Tab['match']=$match;
    $Tab['manche']=$manche;
    $Tab['sponsor']=$sponsor;
    $Tab['table']=$table;
    
    //creation du json
    $strsortie = json_encode( $Tab );
    $fic=fopen('tmp/InfoTournoi.json','w');
    fwrite($fic, $strsortie);
    fclose($fic);
     
 
}