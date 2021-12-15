
<?php
session_start();
var_dump($_SESSION['userId']);
$userId = ($_SESSION['userId']);
echo $userId;
?>