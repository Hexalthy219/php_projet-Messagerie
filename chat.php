<?php
session_start();
if(!isset($_SESSION['error_msg_size']))
   $_SESSION['error_msg_size'] = false;

require "model/modele.php";

$messages = null;

if(isset($_GET['recepteur']) && $_GET['recepteur']!=null){
   $_SESSION['recepteur'] = $_GET['recepteur'];
   $messages = getMsgRec($_GET['recepteur']);
}
else{
   $_SESSION['recepteur'] = null;
   $messages = getMsg();
}
$_SESSION['messages'] =$messages->fetch_all(MYSQLI_ASSOC);
$_SESSION['nbr_messages'] = $messages->num_rows;
$_SESSION['page'] = 0;

require "view/vueChat.php";