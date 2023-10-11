<?php
   session_start();

   require 'model/modele.php';

   $_SESSION['error_msg_size'] = false;

   //protection html injection
   if(isset($_POST["new_msg"]))
      $_POST["new_msg"] = htmlspecialchars($_POST["new_msg"]);
   
   if(strlen($_POST['new_msg'])<=1000){
      if(isset($_SESSION['recepteur']) && $_SESSION['recepteur']!=null)
         sendMsg($_POST['new_msg'], $_SESSION['pseudo'], $_SESSION['recepteur']);
      else
         sendMsg($_POST['new_msg'], $_SESSION['pseudo'], null);
   }
   else
      $_SESSION['error_msg_size'] = true;

   
   $header_link = "chat.php";
   if(isset($_SESSION['recepteur']) && $_SESSION['recepteur']!=null)
      $header_link = $header_link."?".$_SESSION['recepteur'];
   header("Location:".$header_link);