<?php

require_once('../includes/Oauth.php');
require_once('../includes/Facebook.php');

session_start();

$app_id = '1410894852515369';
$app_secret = 'a383d524b04467ebde7226b97e65d875';
$callback = 'niobo.pt/lensfinder/auth/facebook.php'; // [DOMAIN]/auth/facebook.php in this example

$facebook = new Facebook($app_id, $app_secret, $callback);
if($facebook->validateAccessToken()){
        header('Location: ../index.php');
}

exit;
?>