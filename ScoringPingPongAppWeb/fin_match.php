<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

If ($_POST['fin_match'])
{
    
     $req="UPDATE manche set point_j1=:score1, point_j2=:score2 where id_manche=:manche ";
     $req_update= $bdd ->prepare($req);
     $req_update->execute (array('manche'=>$Val['id_manche'],'score1'=>$scorej1, 'score2'=>$scorej2));
     
}
    