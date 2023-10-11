<?php
   function connexionBDD(){
      // return new mysqli("localhost", "id20873388_cyril", "RsuFYJ!LKOhUqL*E#dk0", "id20873388_heplphp");
      return new mysqli("localhost", "userexo11", "userexo11", "exo11");
   }
   
   function newInscription($pseudo, $mdp, $genre, $ddn, $img){
      $imgPath = null;
         $uploadDirectory = 'img/';

         $validExtensions = array('jpg', 'jpeg', 'png');
         $fileName = basename($img['name']);
         $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
         if (!in_array($fileExtension, $validExtensions))
            return -5;

         $imageSize = getimagesize($img['tmp_name']);
         if($imageSize[0]>400 || $imageSize[1]>400)
            return -5;
         $imgPath = $uploadDirectory . $pseudo .".". $fileExtension;

         if (!move_uploaded_file($img['tmp_name'], $imgPath))
            return -5;
      //init
      $connexion = false;
      $mysqli = connexionBDD();

      //Récupération utilisateur ayant le pseudo dont on veut créer une inscription pour vérifier s'il est déjà utilisé
      $stmt = $mysqli->prepare("SELECT pseudo FROM utilisateur WHERE pseudo=?");
      $stmt->bind_param("s", $pseudo);
      $stmt->execute();
      $result = $stmt->get_result();

      //pseudo déjà utilisé
      if($result->num_rows > 0){
         $mysqli->close();
         return -1;
      }
      //check age min 14 ans
      $date_naiss = new DateTime($ddn);
      if(((new DateTime())->diff($date_naiss))->y < 14){
         $mysqli->close();
         return -3;
      }

      $mdp_hash = password_hash($mdp, PASSWORD_DEFAULT);
      if($imgPath===null){
         $stmt = $mysqli->prepare("INSERT INTO utilisateur(pseudo, mdp, genre, ddn) VALUES(?, ?, ?, STR_TO_DATE(?,'%Y-%m-%d'))");
         $stmt->bind_param("ssss", $pseudo, $mdp_hash, $genre, $ddn);
      }
      else{
         $stmt = $mysqli->prepare("INSERT INTO utilisateur VALUES(?, ?, ?, STR_TO_DATE(?,'%Y-%m-%d'), ?)");
         $stmt->bind_param("sssss", $pseudo, $mdp_hash, $genre, $ddn, $imgPath);
      }
      $stmt->execute();
      $result = $stmt->get_result();
      $mysqli->close();

      $_SESSION['pseudo'] = $pseudo;
      $_SESSION['mdp'] = $mdp;
      $_SESSION['genre'] = $genre;
      $_SESSION['ddn'] = $ddn;
      $_SESSION['image'] = null;

      if(strlen($stmt->error)>0)
         return -2;
      
      return 0;
   }

   function connexion($pseudo, $mdp){
      //init
      $connexion = false;
      $mysqli = connexionBDD();

      //execution de la requête de récupération du mdp correspondant au $pseudo
      $stmt = $mysqli->prepare("SELECT mdp, genre, ddn, avatar FROM utilisateur WHERE pseudo=?");
      $stmt->bind_param("s", $pseudo);
      $stmt->execute();
      $result = $stmt->get_result();

      //Si resultat à la requête, compare le résultat au $mdp
      if($result->num_rows > 0){
         $row = $result->fetch_assoc();
         $mpdBdd = $row['mdp'];
         if(password_verify($mdp, $mpdBdd)){
            $connexion = true;
            $_SESSION['pseudo'] = $pseudo;
            $_SESSION['mdp'] = $mdp;
            $_SESSION['genre'] = $row['genre'];
            $_SESSION['ddn'] = $row['ddn'];
            $_SESSION['image'] = $row['avatar'];
         }
      }

      $mysqli->close();
      return $connexion;
   }

   function getMsg(){
      //init
      $mysqli = connexionBDD();

      //execution de la requête de récupération de la liste des utilisateurs
      $stmt = $mysqli->query("SELECT * FROM chatMessage WHERE recepteur IS NULL ORDER BY temps DESC");
      $mysqli->close();

      return $stmt;
   }

   function getMsgRec($recepteur){
      //init
      $mysqli = connexionBDD();

      //execution de la requête de récupération de la liste des utilisateurs
      $stmt = $mysqli->prepare("SELECT * FROM chatMessage WHERE (recepteur = ? AND emetteur=?) OR (recepteur=? AND emetteur=?) ORDER BY temps DESC");
      $stmt->bind_param("ssss", $recepteur, $_SESSION['pseudo'], $_SESSION['pseudo'],$recepteur);
      $stmt->execute();
      $result = $stmt->get_result();
      $mysqli->close();

      return $result;
   }

   function getGenre($pseudo){
      //init
      $mysqli = connexionBDD();

      //execution de la requête de récupération du genre
      $stmt = $mysqli->prepare("SELECT genre FROM utilisateur WHERE pseudo = ?");
      $stmt->bind_param("s", $pseudo);
      $stmt->execute();
      $stmt->bind_result($genre);
      $stmt->fetch();
      $mysqli->close();

      return $genre;
   }

   function getUsers(){
      //init
      $mysqli = connexionBDD();

      //execution de la requête de récupération de la liste des utilisateurs
      $stmt = $mysqli->query("SELECT pseudo FROM utilisateur ORDER BY pseudo");
      $mysqli->close();

      return $stmt;

   }

   function getImg($pseudo){
      //init
      $mysqli = connexionBDD();

      //execution de la requête de récupération de l'image
      $stmt = $mysqli->prepare("SELECT avatar FROM utilisateur WHERE pseudo = ?");
      $stmt->bind_param("s", $pseudo);
      $stmt->execute();
      $stmt->bind_result($img);
      $stmt->fetch();
      $mysqli->close();

      return $img;
   }

   function sendMsg($newMsg, $sender, $recepteur){
      //init
      $mysqli = connexionBDD();

      if($recepteur==null){
      //insertion du msg dans la bdd
         $stmt = $mysqli->prepare("INSERT INTO chatMessage (message, emetteur) VALUES (?, ?)");
         $stmt->bind_param("ss", $newMsg, $sender);
      }
      else{
         $stmt = $mysqli->prepare("INSERT INTO chatMessage (message, emetteur, recepteur) VALUES (?, ?, ?)");
         $stmt->bind_param("sss", $newMsg, $sender, $recepteur);
      }
      $stmt->execute();
      $result = $stmt->get_result();
      $mysqli->close();
   }