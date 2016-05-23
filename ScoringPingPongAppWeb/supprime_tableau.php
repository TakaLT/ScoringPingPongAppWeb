<?php
include 'connexion.php';


if (isset($_GET['action']))
    {

    if ( ( $_GET['action']=='supp' ) && ( $_GET['id_tableau']!='' ) ) 
       {
                //suppression de la base de donnée
                $req='DELETE FROM tableau WHERE id_tableau = :id_tableau';
                $req_suppression= $bdd -> prepare($req);
                $req_suppression-> execute(array('id_tableau'=>$_GET['id_tableau']));

        }
} 
      
        include 'tableau.php';