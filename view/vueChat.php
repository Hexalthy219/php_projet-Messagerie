<!DOCTYPE html>
<html lang="fr">
   <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Chat Exam Php</title>
      <link rel="stylesheet" href="css/style.css">
      <link rel="stylesheet" href="css/template.css">
   </head>
   <body>
   <div class="container">
   <?php include 'header.php'?>
   <br><br><br>
   <div id="page_link">
      <a href="previousPage.php">Page Précédente</a>
      <a href="nextPage.php">Page Suivante</a>
   </div>
   <div class="msg_et_users">
      <div class="emetteur_choice">
            <a href="chat.php">all</a>
            <br>
            <?php foreach(getUsers() as $user):?>
               <a href="chat.php?recepteur=<?php echo $user['pseudo'];?>"><?php echo $user['pseudo'];?></a>
               <br>
            <?php endforeach; ?>
      </div>
      <div class="messaging">
         
         <div class="inbox_msg">
            <div class="mesgs">
               <div class="msg_history">
                  <!-- affichage messages -->
                  <?php 
                     $index = ($_SESSION['page']*20);
                     for($i = 0; ($index+$i)<$_SESSION['nbr_messages'] && $i<20; $i++):
                        $message = $_SESSION['messages'][$index+$i];?>
                  <?php if($message['emetteur']!=$_SESSION['pseudo']):?>
                     <div class="incoming_msg">
                        <?php 
                           $img = getImg($message['emetteur']);
                           if($img!=null)
                              echo "<img src=\"$img\" alt=\"sunil\" class=\"avatar\">";
                        ?>
                        <div class="received_msg">
                           <div class="received_withd_msg">
                              <span 
                              <?php 
                              switch(getGenre($message['emetteur'])){
                                 case "S":
                                    echo "class=\"aucun_genre\"";
                                    break;
                                 case "M":
                                    echo "class=\"masculin\"";
                                    break;
                                 case "F":
                                    echo "class=\"feminin\"";
                                    break;
                              }
                              ?>
                              >
                                 <?php echo $message['emetteur']; ?>
                              </span>
                              <p><?php echo $message['message']; ?></p>
                              <span class="time_date"><?php echo $message['temps']; ?></span>
                           </div>
                        </div>
                     </div>
                  <?php else:?>
                     <div class="outgoing_msg">
                        <div class="sent_msg">
                           <div class="received_withd_msg">
                              <span 
                              <?php 
                              switch(getGenre($message['emetteur'])){
                                 case "S":
                                    echo "class=\"aucun_genre\"";
                                    break;
                                 case "M":
                                    echo "class=\"masculin\"";
                                    break;
                                 case "F":
                                    echo "class=\"feminin\"";
                                    break;
                              }
                              ?>
                              >
                              </span>
                              <p><?php echo $message['message']; ?></p>
                              <span class="time_date"><?php echo $message['temps']; ?></span>
                           </div>
                        </div>
                     </div>
                  <?php endif;?>
                  <?php endfor;?>
                  <br><br><br>
               </div>
         </div>
      </div>

      <form action="sendNewMsg.php" method="post" class="form_msg" >
         <?php if(isset($_SESSION['error_msg_size'])&&$_SESSION['error_msg_size']):?>
            <span class="error">Votre message ne peut faire que 1000 caractères maximum.</span>
            <br>
         <?php endif; ?>
         <input type="text" name="new_msg" id="new_msg" autocomplete="off" class="input_msg_write">
         <button type="submit" id="submit_new_msg" class="msg_send_btn"><img src="static/noun-send.png" alt=""></button>
      </form>
      </div>
      </div>
      
   </body>
</html>