<?php

require_once __DIR__ .'/../../Controller/ActionController.php';

// Creating object of ActionController class.
$action =new ActionController();

$action->validateRegister($_POST['first_name'],
$_POST['last_name'], $_POST['email_id'], $_POST['password']);
