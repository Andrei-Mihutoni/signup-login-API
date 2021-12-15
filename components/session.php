<?php
if (!isset($_SESSION['first_name'])) {
    header('Location: login.php');
    exit();
}
