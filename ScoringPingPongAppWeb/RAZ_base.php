<?php
//On inclut les fichiers connexion et conf 
include 'connexion.php';
include_once('lang/lang_conf.php');

if (isset($_GET['action']))
    {
    if  ( $_GET['action']=='RAZ' )  
       {
    
            $req='DELETE FROM tournoi';
            $req_suppression= $bdd -> prepare($req);
            $req_suppression -> execute();
              
            $req='DELETE FROM sponsor';
            $req_suppression1= $bdd -> prepare($req);
            $req_suppression1 -> execute();
            
            $req='DELETE FROM pub';
            $req_suppression2= $bdd -> prepare($req);
            $req_suppression2 -> execute();
            
            $req='DELETE FROM tour';
            $req_suppression3= $bdd -> prepare($req);
            $req_suppression3 -> execute();
            
            $req='DELETE FROM competiteur';
            $req_suppression4= $bdd -> prepare($req);
            $req_suppression4 -> execute();
            
            $req='DELETE FROM parametre WHERE id_parametre  != 1';
            $req_suppression5= $bdd -> prepare($req);
            $req_suppression5 -> execute();
            
            echo '<h3>'.__mes10.'</h3>';

        }
    }
include 'selection_RAZ.php';