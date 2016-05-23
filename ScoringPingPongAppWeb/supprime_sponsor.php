<?php
include 'connexion.php';


if (isset($_GET['action'])){

if ( ( $_GET['action']== 'supp' ) && ( $_GET['id_img']!='' ) ) 
            {
          
            $id_sponsor=$_GET['id_img'];

            $req='DELETE FROM sponsor WHERE id_sponsor = :id_sponsor';
                $req_suppression= $bdd -> prepare($req);
                $req_suppression-> execute(array('id_sponsor'=>$id_sponsor));        

        }
}   
        include 'sponsor.php';