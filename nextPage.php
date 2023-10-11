<?php
   session_start();
   require "model/modele.php";
   if((($_SESSION['page']+1)*20) <= $_SESSION['nbr_messages'])
      $_SESSION['page']++;
      
   require "view/vueChat.php";