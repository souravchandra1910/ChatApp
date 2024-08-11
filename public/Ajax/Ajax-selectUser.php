<?php

require_once __DIR__ . '/../../Controller/ActionController.php';

// // Creating object of ActionController class.
$action = new ActionController();


$row=$action->selectedUser($_POST['user_id']);
session_start();
if(isset($_SESSION['receiver_email']) && isset($_SESSION['receiver_name'])){
  unset($_SESSION['receiver_email']);
  unset($_SESSION['receiver_name']);
}
$_SESSION['receiver_email']=$row['email_id'];
$_SESSION['receiver_name']=$row['first_name'] . " " . $row['last_name'];
