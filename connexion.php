<?php
   session_start();

   $_SESSION['status'] = 'connexion';

   require 'view/vueConnexion.php';