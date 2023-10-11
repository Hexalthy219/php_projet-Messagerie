<?php
   session_start();
   require "model/modele.php";
   if($_SESSION['page']>0)
      $_SESSION['page']--;

   require "view/vueChat.php";
   