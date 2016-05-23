<?php
// On démarre la session 
session_start ();

//On inclut le fichiers conf 
include_once('lang/lang_conf.php');

// On récupère notre variable de session
if (isset($_SESSION['utilisateur']) && ($_SESSION['utilisateur'] != ''))
    {
    echo '<html>';
    echo '<head>';
    echo '<title>Pub</title>';
    echo '</head>';
    }
else {
//echo 'Les variables ne sont pas déclarées.';
}
?><!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title><?=__aff_pub ?></title>
    </head>
    <body>
        <?php
        include 'connexion.php';
            
        ?>
        <header>
           
        </header>
            <div id="slides">
                <div class="slides-container">
                <?php 

                    $req_p="select * from pub";
                    $req_p = $bdd -> query ($req_p);
                     while ($data_pub=$req_p->fetch())  {     

                    ?>
                    <img src="pub/<?=$data_pub['nom_pub']?>">
                    <?php
                    }
                ?>
                </div>
            </div>
        <footer>
            <a href="menu.php" ><?=__Retour ?></a><br/>
        </footer>  
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script type="text/javascript" src="/<?=$Rep?>jQuery/jquery-1.11.1.js"></script>
        <script type="text/javascript" src="/<?=$Rep?>JS/jquery.easing.1.3.js"></script>
        <script type="text/javascript" src="/<?=$Rep?>JS/jquery.animate-enhanced.min.js"></script>
        <script src="/<?=$Rep?>JS/jquery.superslides.js" type="text/javascript" charset="utf-8"></script>
        <script>
          $(function() {

            $('#slides').superslides({
              hashchange: true,
              play: 5000
            });

          });
        </script>
    </body>
</html>




