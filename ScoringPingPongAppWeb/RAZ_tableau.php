<?php
//On inclut les fichiers connexion et conf 
include 'connexion.php';
include_once('lang/lang_conf.php');

if (isset($_GET['action']))
    {
    if  ( $_GET['action']=='RAZ' )  
       {
        // en cas de suppression on controle le nombre d'entrer de la table tableau
        
            $req='SELECT * FROM tableau';
            $req_verif=$bdd->query($req);
            $nbreligne=$req_verif->rowCount();

             if ($nbreligne >0)                 
                {
                    $req='DELETE FROM tableau';
                    $req_suppression= $bdd -> prepare($req);
                    $req_suppression -> execute();
                    
                    echo '<h3>'.__mes13.'</h3>';
                }
            else 
                {
                    echo '<h3>'.__mes14.'</h3>';
                }
        }
    }
include 'selection_RAZ.php';