<?php

include 'connexion.php';

if( $_POST['fin'])
   {
    // recuperation des variable
    $match=$_POST['match'];
    $manche = $_POST['manche'];
    $nomj1 = $_POST['nomj1'];
    $nomj2 = $_POST['nomj2'];
    $paysj1 =$_POST['paysj1'];
    $paysj2 =$_POST['paysj2'];
    $table =$_POST['table'];
    $resj1 = $_POST['resj1'];
    $resj2 = $_POST['resj2'];
    $num_manche=$_POST['num_manche'];
    
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
    
     $NbManche=$manche;
      
        for ($e2=1;$e2<=$NbManche;$e2++)
        {

            ${'scorej1m'.$e2} =$_POST['scorej1m'.$e2];
            ${'scorej2m'.$e2} =$_POST['scorej2m'.$e2];


            //recuperation de l'id _manche
            $req="SELECT id_manche from manche where num_manche=:manche and id_matchs=:match";
            $req_select2= $bdd ->prepare($req);
            $req_select2->execute (array('manche'=>$manche, 'match'=>$match));
            $Val=$req_select2->fetch();

            //mise a jour des scores 
            $req="UPDATE manche set point_j1=:score1, point_j2=:score2 where id_manche=:manche ";
            $req_update= $bdd ->prepare($req);
            $req_update->execute (array('manche'=>$Val['id_manche'],'score1'=>${'scorej1m'.$e2}, 'score2'=>${'scorej2m'.$e2}));

        }
        
        //mise a jour de la table match        
        $req="UPDATE matchs SET temps_mort_j1= :tmj1 , temps_mort_j2= :tmj2, faute_cj_j1= :jaunej1, faute_cj_j2= :jaunej2, faute_cjcr1_j1= :jr1j1, faute_cjcr1_j2= :jr1j2, faute_cjcr2_j1= :jr2j1, faute_cjcr2_j2= :jr2j2, forfait_j1= :woj1, forfait_j2= :woj2, id_statut= :statut   WHERE id_matchs = :id_matchs";
        $req_update= $bdd ->prepare($req);
        $req_update->execute (array('tmj1'=>$tmj1,'tmj2'=>$tmj2, 'jaunej1'=>$jaunej1,'jaunej2'=>$jaunej2,'jr1j1'=>$jr1j1,'jr1j2'=>$jr1j2, 'jr2j1'=>$jr2j1,'jr2j2'=>$jr2j2,'woj1'=>$woj1,'woj2'=>$woj2,'statut'=>3, 'id_matchs'=>$match ));

   }