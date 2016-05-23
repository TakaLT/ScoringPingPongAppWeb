<?php
include 'connexion.php';
include_once('lang/lang_conf.php');



if (isset($_GET['action'])){

    if ( ( $_GET['action']=='supp' ) && ( $_GET['id_parametre']!='' ) ) 
       {
    
        if ($_GET['id_parametre']!=1 )
                {
          
                $req='DELETE FROM parametre WHERE id_parametre = :id_parametre';
                $req_suppression= $bdd -> prepare($req);
                $req_suppression-> execute(array('id_parametre'=>$_GET['id_parametre']));
                //echo 'le dernier tournoi est supprimer ';
                            
                }
        else 
                {
                    echo '<h3>'.__mes24.'</h3>';
                }
       
} 
}
      
        include 'parametre.php';