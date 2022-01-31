<?php
require_once(__DIR__ . '/../globals/globals.php');



// VALIDATE email
if (!isset($_POST['email'])) {send_400('email is required');}
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {send_400('email is invalid');}


// Connect to DB
$db = _db();

try {
  // Select the matching mail from the DB
  $query = $db->prepare(' SELECT * FROM users  WHERE email = :email');
  $query->bindValue(':email', $_POST['email']);
  $query->execute();
  $row = $query->fetch();
  // var_dump($row);
  // print_r($row);
  // echo json_encode($row['pwd_reset_key']);

 ;

  // SUCCESS
  $response = ["info" => "A reset password link has beem sent to your email. Please follow the instructions received in the email. You can now close this page.", "to" => $_POST['email']];
  echo json_encode($response);
} catch (Exception $ex) {
  http_response_code(500);
  echo 'System under maintainance';
  echo $ex;
  exit();
}
// takes from the DB the "reset password key" assosiated with the email address 
$pwd_reset_key = $row['pwd_reset_key'];

// sends the "reset password" mail with the "reset password key"
$_subject = "Password reset request";
$_to_email = $_POST['email'];
$_message = "You have requested a password reset. 
      <a href='http://localhost/pwd_reset.php?pwd_reset_key=$pwd_reset_key'> 
         Click here to reset your password. 
      </a>";

require_once(__DIR__ . "/../private/send_email.php");


// function to manage responding in case of an error
function send_400($error_message)
{
  header('Content-Type: application/json');
  http_response_code(400);
  $response = ["info" => $error_message];
  // echo json_encode($response);
  exit();
}
