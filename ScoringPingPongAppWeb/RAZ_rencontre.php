<?php
//On inclut les fichiers connexion et conf 
include 'connexion.php';
include_once('lang/lang_conf.php');

if (isset($_GET['action']))
    {
    if  ( $_GET['action']=='RAZ' )  
       {
    
    // en cas de suppression on controle le nombre d'entrer de la table matchs et participation        
       
        $req='SELECT * FROM matchs';
        $req_verif=$bdd->query($req);
        $nbreligne=$req_verif->rowCount();
        
        $req='SELECT * FROM participation';
        $req_verif2=$bdd->query($req);
        $nbreligne2=$req_verif2->rowCount();


             if (($nbreligne >0) ||($nbreligne2 >0))                 
            {
                          
            $req='DELETE FROM matchs';
            $req_suppression= $bdd -> prepare($req);
            $req_suppression -> execute();
            $req='DELETE FROM participation';
            $req_suppression1= $bdd -> prepare($req);
            $req_suppression1 -> execute();    
            
            echo '<h3>'.__mes19.'</h3>';

            }
        else 
            {
                echo '<h3>'.__mes20.'</h3>';                
            }        
        }
    }
include 'selection_RAZ.php';
