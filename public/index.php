<!-- Routing -->
<?php

require_once __DIR__ .'/../Controller/UrlMangager.php';


$manage_url = new UrlManagement();


$url = $_SERVER['REQUEST_URI'];
$url1 = explode("?", $url);
$url = explode("/", $url1[0]);
switch ($url[1]) {
  case '':
    $manage_url->Login();
    break;
  case 'register':
    $manage_url->register();
    break;
  case 'reset':
    $manage_url->reset();
    break;
  case 'logout':
    $manage_url->logout();
    break;
  case 'otp':
    $manage_url->Otp();
    break;
  case 'home':
    $manage_url->home();
    break;
  default:
    $manage_url->default();
}
