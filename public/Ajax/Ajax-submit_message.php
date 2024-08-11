<?php

require_once __DIR__ . '/../../Controller/ActionController.php';

// // Creating object of ActionController class.
$action = new ActionController();

$sender_email = $_POST['sender_email'];
$receiver_email = $_POST['receiver_email'];
$message = $_POST['message'];
$action->insertMessage($sender_email,$receiver_email,$message);

