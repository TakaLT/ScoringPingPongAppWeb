<?php

include 'connexion.php';

if (isset($_GET['action']))
    {

    if ( ( $_GET['action']=='supp' ) && ( $_GET['id_tour']!='' ) ) 
           {
            
            $id_tour=$_GET['id_tour'];
           
            //suppression du tour         
            $req='DELETE FROM tour WHERE id_tour = :id_tour';
            $req_suppression= $bdd -> prepare($req);
            $req_suppression-> execute(array('id_tour'=>$id_tour));

           }
            
            
    }
            include 'tour.php';

