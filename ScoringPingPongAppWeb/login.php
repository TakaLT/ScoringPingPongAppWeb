<?php
//connexion a la base de donnée
include ('connexion.php'); 

if (isset($_POST['valide'])&& !empty($_POST['utilisateur']) && !empty($_POST['password']))
    {
    //enregistrement champs dans une variable
    $utilisateur = htmlspecialchars($_POST['utilisateur']);
    $password = htmlspecialchars($_POST['password']);
    
    // on recupère l'utilisateur et le password dans la Bdd si erreur on quitte
    $sql = "select utilisateur, password from profil inner join password on profil.id_utilisateur = password.id_utilisateur where utilisateur = '".$utilisateur."'"  ;
    $req = $bdd -> query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());    
    $data=$req->fetch();
       
    $req->closeCursor(); 
   
    //condition si l'utilisateur ou le password n'est pas dns la base de donnée     
    if(($data['utilisateur'] != $utilisateur )||($data['password'] != $password))
        {
        //echo $data['utilisateur'];
        //echo $data['password'];
        echo '<p>L\'utilisateur ou le password n\'existe pas. Merci de recommencer</p>';
        include('accueil.php'); // On inclut le formulaire d'index
        exit;
        } 
    else
        {
                                                                                                    
        //on inclue le choix selon le'utilisateur
        switch ($utilisateur)
            {
                case 'admin':
                    //demarrage session avec parametre admin
                    session_start();
                    $_SESSION['utilisateur']=$utilisateur;
                    //redirection vers page menu reservé a m'admin
                    header('Location: menu.php');
                    break;
                case 'score':
                    //demarrage session avec parametre score
                    session_start();
                    $_SESSION['utilisateur']=$utilisateur;
                    //redirection vers page de score reservé au scoreur
                    header('Location: selection_match.php');
                    break;
                case '':
                    break;

            }
        }
         
    }         
else 
    {
        echo '<p>Vous avez oublié de remplir un champ.</p>';
        include('accueil.php'); // On inclut le formulaire d'identification
        exit;
    }

