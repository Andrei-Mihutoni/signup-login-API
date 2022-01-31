<?php
require_once(__DIR__ . '/../globals/globals.php');

// VALIDATE first name
if (!isset($_POST['first_name'])) {send_400('first name is required');}  //check if the name is passed
if (strlen($_POST['first_name']) < 2) {send_400('first name must have minimum 2 characters');}   // check if the name contain at least 2 character
if (strlen($_POST['first_name']) > 30) {send_400('first name must have maximum 30 characters');
}   // check if the name contain at least 2 character

// VALIDATE last_name
if (!isset($_POST['last_name'])) {send_400('last name is required');}  //check if the last_name is passed
if (strlen($_POST['last_name']) < 2) {send_400('last name must have minimum 2 characters');}   // check if the last_name contain at least 2 character
if (strlen($_POST['last_name']) > 15) {send_400('last name must have maximum 15 characters');}      // check if the last_name contain at least 2 character

// VALIDATE phone_number
if (!isset($_POST['phone_number'])) {_res(400, ['info' => 'phone number required']);};
if (strlen($_POST['phone_number']) < 8) {_res(400, ['info' => 'phone number too short. Phone number length shoud be minimum 8 digits']);};
if (strlen($_POST['phone_number']) > 8) {_res(400, ['info' => 'phone number too long. Phone number length shoud be maximum 8 digits']);
};

// VALIDATE email
if (!isset($_POST['email'])) {send_400('email is required');}
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {send_400('email is invalid');}


// VALIDATE userId
// if(!isset($_GET['userId'])) {send_400('userId is required');};
// if(!ctype_digit($_GET['userId'])){send_400('userId must be a digit');};


// Connect to DB
$db = _db();

try{
    session_start();
    $userId = ($_SESSION['userId']);
    // $userId = $_POST['userId'];

    // Insert data in the DB
    $query = $db->prepare('UPDATE users SET first_name=:first_name, last_name=:last_name, phone_number=:phone_number, email=:email WHERE userId = :userId');
    $query->bindValue(":first_name", $_POST['first_name']);
    $query->bindValue(":last_name", $_POST['last_name']);
    $query->bindValue(":phone_number", $_POST['phone_number']);
    $query->bindValue(":email", $_POST['email']);
    $query->bindValue(":userId" , $userId);
    // $query->bindValue(":userId" , $_POST['userId']);
    $query->execute();

    if(!$query->rowCount()){
        // send_400('user not found');
        exit();
    }
    // SUCCESS
    $response = ["info" => "Account updated. Please log in again."];
    echo json_encode($response);
    session_destroy();
    session_start();
} catch (Exception $ex) {
    http_response_code(500);
    echo 'System under maintainance';
    echo $ex;
    exit();
  }

// function to manage responding in case of an error
function send_400($error_message)
{
  header('Content-Type: application/json');
  http_response_code(400);
  $response = ["info" => $error_message];
  echo json_encode($response);
  exit();
}
