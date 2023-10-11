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
      <h1>Connexion</h1>
      <form action="formProcessingPage.php" method="post" class="form-class">
         <?php
            if(isset($_SESSION["erreur"]) && $_SESSION["erreur"])
               echo "<span class=\"error\"> Veuillez ne pas laisser de champs vides</span><br>";
            ?>

         <label for="pseudo">Nom d'utilisateur :</label>
         <br>
         <input type="text" name="pseudo">

         <br>
         <label for="mdp">Mot de passe :</label>
         <br>
         <?php
         if(isset($_SESSION['mauvais_mdp'])&&$_SESSION['mauvais_mdp'])
               echo "<span class=\"error\"> Mot de passe incorrect!</span><br>";
         ?>
         <input type="password" name="mdp">
         <br>
         <button type="submit" class="btn_submit">Se connecter</button>
         <span>Pas encore de compte?</span>
         <a href="index.php">S'inscrire</a>
      </form>
   </div>
      

</body>
</html>