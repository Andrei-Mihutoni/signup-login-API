<?php
$amazonLink = (__DIR__ . '/txt-files/amazon-html.txt');
$body = file_get_contents($amazonLink);
echo $body;
?>


<?php
require_once(__DIR__ . '/components/footer.php');
?>