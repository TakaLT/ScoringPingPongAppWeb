<?php
//On inclut les fichiers connexion et conf 
include 'connexion.php';
include_once('lang/lang_conf.php');

if (isset($_GET['action']))
    {
    if  ( $_GET['action']=='RAZ' )  
       {
        // en cas de suppression on controle le nombre d'entrer de la table tournoi   
        
            $req='SELECT * FROM tournoi';
            $req_verif=$bdd->query($req);
            $nbreligne=$req_verif->rowCount();
            
            if ($nbreligne >0)
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

                    echo '<h3>'.__mes11.'</h3>';
                }
            else 
                {
                    echo '<h3>'.__mes12.'</h3>';
                }
            }
        }
include 'selection_RAZ.php';