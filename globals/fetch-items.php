<?php
include_once(__DIR__ . '/globals.php');
// Connect to DB
$db = _db();
try {

    // Get data in the DB
    $query = $db->prepare('SELECT * FROM items');
    $query->execute();
    $itemsData = $query->fetchAll();

    // SUCCESS
    // $response = ["info" => "items updated"];
    // echo json_encode($response);
} catch (Exception $ex) {
    http_response_code(500);
    echo 'System under maintainance';
    echo $ex;
    exit();
}
