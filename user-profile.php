
<?php
// session_start();
// var_dump($_SESSION['userId']);
// $userId = ($_SESSION['userId']);
// echo $userId;
require_once(__DIR__ . '/globals/globals.php');

session_start();
// echo $_SESSION['car'];
$car = $_SESSION['car'];
echo $car;
?>