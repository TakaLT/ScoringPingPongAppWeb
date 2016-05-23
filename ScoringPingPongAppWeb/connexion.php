<?php
    $serveur="Localhost";
    $base="live_scoring";
    $identifiant="root";
    $mot_de_passe="";

    try
    {
	$bdd = new PDO('mysql:host='.$serveur.';dbname='.$base.'',''.$identifiant.'',''.$mot_de_passe.'',array(PDO::ATTR_ERRMODE => PDO:: ERRMODE_EXCEPTION ));
	//echo 'vous etes connecté a la base ' ;
    }
    catch (Exception $e)
    {
	die('Erreur : '.$e->getMessage());
    }


	
