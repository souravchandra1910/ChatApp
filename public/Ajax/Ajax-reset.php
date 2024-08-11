<?php

require_once __DIR__ . '/../../Controller/ActionController.php';

// Creating object of ActionController class.
$action =new ActionController();

// Reseting password.
$ans=$action->resetPassword($_POST['email_id'], $_POST['password']);
