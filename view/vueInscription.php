<!DOCTYPE html>
<html lang="fr">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="css/style.css">
   <title>Chat Exam Php</title>
</head>
<body>
   <div class="formulaire">
      <h1>Inscription</h1>
      <?php if(isset($_SESSION['erreur_bdd']) && $_SESSION['erreur_bdd']):?>
         <span class="error">Une erreur s'est produite lors de la tentative d'inscription. Veuillez réessayer.</span><br>
      <?php endif;?>
      <form action="formProcessingPage.php" method="post" class="form-class" enctype="multipart/form-data">
         <?php if(isset($_SESSION["erreur"])&&$_SESSION["erreur"]):?>
            <span class="error"> Veuillez ne pas laisser de champs vides</span><br>
         <?php  elseif(isset($_SESSION['alreadyExists'])&&$_SESSION['alreadyExists']):?>
            <span class="error">Ce nom d'utilisateur existe déjà</span><br>
         <?php endif;?>

         <label for="pseudo">Nom d'utilisateur :</label>
         <br>
         <input type="text" name="pseudo">
         <br>
         <span class="info_input <?php if(isset($_SESSION["erreur_regex"])&&$_SESSION["erreur_regex"])echo "error";?>">entre 8 et 15 caractères, une minuscule, une majuscule et un caractère spécial.</span>
         <br>

         <label for="mdp">Mot de passe :</label>
         <br>
         <input type="password" name="mdp">
         <br>
         <span class="info_input <?php if(isset($_SESSION["erreur_regex"])&&$_SESSION["erreur_regex"])echo "error";?>">entre 8 et 15 caractères, une minuscule, une majuscule et un caractère spécial.</span>
         <br>
         
         <?php if(isset($_SESSION['erreur_confirm_mdp'])&&$_SESSION['erreur_confirm_mdp']):?>
               <span class="error">Les mots de passe ne correspondent pas!</span><br>
         <?php endif;?>
         <label for="mdp_confirm">Confirmation du Mot de passe :</label>
         <br>
         <input type="password" name="mdp_confirm">
         <br>

         <label for="genre">Genre :</label>
         <br>
         <select name="genre">
            <option value="S" selected>Sans Réponse</option>
            <option value="M">Masculin</option>
            <option value="F">Féminin</option>
         </select>
         <br>

         <?php if(isset($_SESSION['trop_jeune'])&&$_SESSION['trop_jeune']):?>
            <span class="error">Vous devez avoir au moins 14 ans pour pouvoir vous inscrire!</span><br>
         <?php endif;?>
         <label for="ddn">Date de Naissance :</label>
         <br>
         <input type="date" name="ddn">
         <br>

         <label for="avatar">Avatar :</label>
         <br>
         <input type="file" name="avatar" id="avatar">
         <br>


         <button type="submit" class="btn_submit">S'inscrire</button>
         <span>Vous possédez déjà un compte?</span>
         <a href="connexion.php">Se connecter</a>
      </form>
   </div>
      

</body>
</html>