<?php
   session_start();

   include 'model/modele.php';
   $_SESSION['erreur'] = false;
   $_SESSION['erreur_bdd'] = false;
   $_SESSION['alreadyExists'] = false;
   $_SESSION['mauvais_mdp'] = false;
   $_SESSION['trop_jeune'] = false;
   $_SESSION['erreur_confirm_mdp'] = false;
   $_SESSION['erreur_regex'] = false;

   // regex pour au moins une maj, une min, un chiffre et un char spécial
   $regex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^\w\s]).{8,15}$/';

   //Protection injection html
   if(isset($_POST["pseudo"]))
      $_POST["pseudo"] = htmlspecialchars($_POST["pseudo"]);
   if(isset($_POST["mdp"]))
      $_POST["mdp"] = htmlspecialchars($_POST["mdp"]);
   if(isset($_POST["mdp_confirm"]))
      $_POST["mdp_confirm"] = htmlspecialchars($_POST["mdp_confirm"]);

   
   //champ set au moins une fois
   if(isset($_POST["pseudo"]) && isset($_POST["mdp"])){
      //Champs pas tous remplis
      if(empty($_POST["pseudo"]) || empty($_POST["mdp"]) || ($_SESSION['status']!='connexion' && empty($_POST['mdp_confirm'])))
         $_SESSION["erreur"] = true;
      else{
         if($_SESSION['status']=='connexion'){
            if(connexion($_POST['pseudo'], $_POST['mdp']))
               $_SESSION['status'] = 'connecté';
            else
               $_SESSION['mauvais_mdp'] = true;
         }
         else{
            if(!preg_match($regex, $_POST["pseudo"]) ||!preg_match($regex, $_POST["mdp"]))
               $_SESSION['erreur_regex'] = true;
            else if($_POST['mdp'] == $_POST['mdp_confirm']){
               switch(newInscription($_POST['pseudo'], $_POST['mdp'], $_POST['genre'], $_POST['ddn'], $_FILES['avatar'])){
                  case 0:
                     $_SESSION['status'] = 'connecté';
                     break;
                  case -1:
                     $_SESSION['alreadyExists'] = true;
                     break;
                  case -2:
                     $_SESSION['erreur_bdd'] = true;
                     break;
                  case -3:
                     $_SESSION['trop_jeune'] = true;
                     break;
               }
            }
            else
               $_SESSION['erreur_confirm_mdp'] = true;
         }
      }
   }

   // //Reload de la page sur laquelle on se trouve car champs incorrects
   if($_SESSION['status']=='connexion'){
      header("Location:connexion.php");
      exit;
   }
   else if($_SESSION['status']=='connecté'){
      header("Location:chat.php");
      exit;
   }
   else{
      //par défaut retour à la page inscription
      header("Location:index.php");
      exit;
   }