<?php
include 'connexion.php';


if (isset($_GET['action'])){

    // en cas de suppression
        if ( ( $_GET['action']=='supp' ) && ( $_GET['id_img']!='' ) ) 
            {
            //enregistre id
            $id_pub=$_GET['id_img'];
            
            $req='DELETE FROM pub WHERE id_pub = :id_pub';
                $req_suppression= $bdd -> prepare($req);
                $req_suppression-> execute(array('id_pub'=>$id_pub));
        
         
        }
        }   
        include 'pub.php';