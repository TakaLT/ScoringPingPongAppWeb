<?php
include 'connexion.php';

if (isset($_GET['action']))
    {

    if ( ( $_GET['action']=='supp' ) && ( $_GET['id_tournoi']!='' ) ) 
           {
                    $req='DELETE FROM tournoi WHERE id_tournoi = :id_tournoi';
                    $req_suppression= $bdd -> prepare($req);
                    $req_suppression-> execute(array('id_tournoi'=>$_GET['id_tournoi']));
                
             }
            
    } 
      
        include 'tournoi.php';