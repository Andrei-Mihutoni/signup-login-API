<?php
session_start();
if( !isset($_SESSION['first_name'])){
    header('Location: login.php');
    exit();
}
?>


<?php
$_title = 'Welcome';
require_once(__DIR__.'/components/header.php');
?>

<body>

<nav>
    <a href="logout.php">Logout</a>
</nav>
    <h1>
        <?php
echo 'Welcome ', $_SESSION['first_name'];

?>
    </h1>
</body>
</html>