<?php
include 'connexion.php';
include_once('lang/lang_conf.php');

if (isset($_GET['action']))
    {

    if ( ( $_GET['action']=='supp' ) && ( $_GET['id_configuration']!='' ) ) 
        {
            if ($_GET['id_configuration']!=1 )
                {
                    //reccuperation de l'id tournoi pour mettre theme par defaut
                    $req="SELECT * FROM tournoi join configuration on configuration.id_configuration='".$_GET['id_configuration']."'";
                    $req=$bdd-> query ($req);
                    $tournoi= $req ->fetch();
                    
                    $id_tournoi= $tournoi['id_tournoi'];
                    
                    //mise a jour du theme du tournoi 
                    $req='UPDATE tournoi SET id_configuration = :id_conf WHERE id_tournoi = :id_tournoi ';
                    $req_tournoi= $bdd->prepare($req);
                    $req_tournoi->execute (array('id_conf'=>1, 'id_tournoi'=>$id_tournoi ));                  
                                      
                    //requète de suppression du theme
                    $req='DELETE FROM configuration WHERE id_configuration = :id_supprimer';
                    $req_suppression= $bdd -> prepare($req);
                    $req_suppression-> execute(array('id_supprimer'=>$_GET['id_configuration']));
                   
                }
            else 
                {
                    echo '<h3>'.__mes24.'</h3>';
                }
        }
    }

 include 'configuration.php';