<?php

session_start();
if (!isset($_SESSION['first_name'])) {
    header('Location: login.php');
    exit();
}
$_title = 'Welcome';
require_once(__DIR__ . '/components/header.php');
echo '<h1> Profile page </h1> ';
?>


<main id="profile-main" class="profile-main">
    <section id="profile-group">
        <h2>Your account details:</h2>
        <p>First name: <span><?= ($_SESSION['first_name']) ?></span></p>
        <p>Last name:<span><?= ($_SESSION['last_name']) ?></span></p>
        <p>Email:<span><?= ($_SESSION['email']) ?></span></p>
        <p>Phone number:<span><?= ($_SESSION['phone_number']) ?></span></p>

        <div class="a-row">
            To update your account details
            <a class="a-link-emphasis" href="update-user.php"> Click here </a>
        </div>
        <div class="a-row">
            For password reset
            <a class="a-link-emphasis" href="pwd_reset_send_email.php"> Click here </a>
        </div>
        </fieldset>

    </section>
</main>