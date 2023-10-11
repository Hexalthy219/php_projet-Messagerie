<?php
   session_start();
   
   $_SESSION['status'] = 'inscription';

   require 'view/vueInscription.php';