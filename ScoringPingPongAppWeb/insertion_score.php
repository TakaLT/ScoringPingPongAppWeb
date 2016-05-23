<?php
include 'connexion.php';

if($_POST)
{
    //enregistrement des variable 
    $manche = $_POST['manche'];
    $scorej1 = $_POST['scorej1m'.$manche];
    $scorej2 = $_POST['scorej2m'.$manche];
    $debut = $_POST['debut'];
    $fin = $_POST['fin'];
    $match = $_POST['matchs'];

    $req="SELECT count(*) as nombre from manche where num_manche=:manche and id_matchs=:match";
    $req_select= $bdd ->prepare($req);
    $req_select->execute (array('manche'=>$manche, 'match'=>$match));
    $Nb=$req_select->fetch();
    
      
    if ($Nb['nombre']==0) 
    {
        $req='INSERT INTO manche (num_manche, point_j1, point_j2, debut_manche, fin_manche, id_matchs) VALUES (:manche, :score1, :score2, :debut, :fin, :match)';
        $req_insert= $bdd ->prepare($req);
        $req_insert->execute (array('manche'=>$manche,'score1'=>$scorej1, 'score2'=>$scorej2, 'debut'=>$debut, 'fin'=>$fin, 'match'=>$match));
    }
    else 
    {
        $req="SELECT id_manche from manche where num_manche=:manche and id_matchs=:match";
        $req_select2= $bdd ->prepare($req);
        $req_select2->execute (array('manche'=>$manche, 'match'=>$match));
        $Val=$req_select2->fetch();

        $req="UPDATE manche set point_j1=:score1, point_j2=:score2 where id_manche=:manche ";
        $req_update= $bdd ->prepare($req);
        $req_update->execute (array('manche'=>$Val['id_manche'],'score1'=>$scorej1, 'score2'=>$scorej2));
    }
}