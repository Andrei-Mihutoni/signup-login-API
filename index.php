<?php
$_title = 'Welcome';
require_once(__DIR__ . '/components/header.php');
$amazonLink = 'amazon-html.txt';
$body = file_get_contents($amazonLink);
echo $body;



// $amazonLink = 'https://www.amazon.com/';
// $body = file_get_contents($amazonLink);
// echo $body;
// $link1 = "https://www.amazon.com/ap/signin?openid.pape.max_auth_age=0&openid.return_to=https%3A%2F%2Flocalhost%2F%3Fref_%3Dnav_ya_signin&openid.identity=http%3A%2F%2Fspecs.openid.net%2Fauth%2F2.0%2Fidentifier_select&openid.assoc_handle=usflex&openid.mode=checkid_setup&openid.claimed_id=http%3A%2F%2Fspecs.openid.net%2Fauth%2F2.0%2Fidentifier_select&openid.ns=http%3A%2F%2Fspecs.openid.net%2Fauth%2F2.0&";
// $header = file_get_contents('amazon-new-header.txt');
// echo $header;
//  echo $body;
//  echo str_replace($link1, $link2, $body);
//  $body1 = str_replace("skip-link", " ", $body);
//  $body2 = str_replace("Skip to main content", "disclaimer: this is a school project not the official Amazon page.", $body1);
//  echo $body2;
//  $body3 = str_replace("nav-a nav-a-2   nav-progressive-attribute", "disclaimer: this is a school project not the official Amazon page.", $body1);
//  echo $body3;
?>


<?php
require_once(__DIR__ . '/components/footer.php');
?>