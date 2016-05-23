<?php
include 'connexion.php';

if (isset($_GET['action']))
    {

    if ( ( $_GET['action']=='supp' ) && ( $_GET['id_competiteur']!='' ) ) 
       {
         
                $req='DELETE FROM competiteur WHERE id_competiteur = :id_competiteur';
                $req_suppression= $bdd -> prepare($req);
                $req_suppression-> execute(array('id_competiteur'=>$_GET['id_competiteur']));      
       
        }
       
} 
      
        include 'competiteur.php';