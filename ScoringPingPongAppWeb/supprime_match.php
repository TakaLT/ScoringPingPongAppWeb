<?php
include 'connexion.php';



if (isset($_GET['action']))
    {
    if ( ( $_GET['action']=='supp' ) && ( $_GET['id_matchs']!='' ) ) 
       {
    
    // en cas de suppression
            $id_match=$_GET['id_matchs'];
            
            $req="SELECT * FROM matchs   WHERE id_matchs='".$id_match."'";
            $req_info = $bdd -> query ($req);
            $req_info=$req_info->fetch();
            
            $req2='DELETE FROM participation WHERE id_tableau = :id_tab  AND id_competiteur1 = :id_c1 AND id_competiteur2 = :id_c2';
            $req_suppression= $bdd -> prepare($req2);
            $req_suppression-> execute(array('id_tab'=>$req_info['id_tableau'], 'id_c1'=>$req_info['id_competiteur1'], 'id_c2'=>$req_info['id_competiteur2']));
  
            $req='DELETE FROM matchs WHERE id_matchs = :id_match';
                $req_suppression= $bdd -> prepare($req);
                $req_suppression-> execute(array('id_match'=>$id_match));
        
          


        }
    }   
        include 'rencontre.php';