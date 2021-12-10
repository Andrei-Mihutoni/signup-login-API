<?php
session_start();
if (!isset($_SESSION['first_name'])) {
    header('Location: login.php');
    exit();
}
?>


<?php
$_title = 'Welcome';
require_once(__DIR__ . '/components/header.php');
?>

<body>

    <nav>
        <a href="logout.php">Logout</a>
    </nav>
    <h1>
        <?php
        echo 'Welcome ', $_SESSION['first_name'];

        $amazonLink = 'https://www.amazon.com/s?i=specialty-aps&bbn=16225009011&rh=n%3A%2116225009011%2Cn%3A502394&ref=nav_em__nav_desktop_sa_intl_camera_and_photo_0_2_5_3
';
        $body = file_get_contents($amazonLink);
        echo $body;


        ?>
    </h1>
</body>

</html>