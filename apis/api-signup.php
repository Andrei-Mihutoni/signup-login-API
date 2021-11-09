<?php
require_once(__DIR__.'/../globals/globals.php');


// VALIDATE name
if ( !isset( $_POST['first_name'] ) ) {send_400('first_name is required');}  //check if the name is passed
if ( strlen( $_POST['first_name'] ) < 2  ) {send_400('first_name must have minimum 2 characters');}   // check if the name contain at least 2 character
if ( strlen( $_POST['first_name'] ) > 15  ) {send_400('first_name must have maximum 15 characters');}   // check if the name contain at least 2 character

// VALIDATE last_name
if ( ! isset( $_POST['last_name'] ) ) {send_400('last_name is required');}  //check if the last_name is passed
if ( strlen( $_POST['last_name'] ) < 2  ) {send_400('last_name must have minimum 2 characters');}   // check if the last_name contain at least 2 character
if ( strlen( $_POST['last_name'] ) > 15  ) {send_400('last_name must have 15 characters'); }      // check if the last_name contain at least 2 character

// VALIDATE email
if ( ! isset ( $_POST['email'] ) ) {send_400('email is required');}
if ( ! filter_var( $_POST['email'], FILTER_VALIDATE_EMAIL ) )  {send_400('email is invalid');}

// VALIDATE password
if ( ! isset($_POST['password'] )) { _res(400, ['info' => 'password required']); };
if ( strlen($_POST['password']) < _PASSW0RD_MIN_LEN ) { _res(400, ['info' => 'password too short. Password length shoud be minimum '._PASSW0RD_MIN_LEN.' charachetrs']); };
if ( strlen($_POST['password']) > _PASSW0RD_MAX_LEN ) { _res(400, ['info' => 'password too long.  Password length shoud be Maximum '._PASSW0RD_MAX_LEN.' charachetrs']); };

// VALIDATE re-password
if ( ! isset($_POST['re-password'] )) { _res(400, ['info' => 're-password required']); };
if (($_POST['re-password'] !== $_POST['password'] )) { _res(400, ['info' => 'passwords do not match']); };

// Connect to DB
$db = require_once(__DIR__.'/../globals/db.php');
try{
  // Insert data in the DB
  $query = $db->prepare('INSERT INTO users VALUES(:user_id, :first_name, :last_name, :email, :password)');
  $query->bindValue(":user_id", null); // The db will give this automaticaly.
  $query->bindValue(":first_name", $_POST['first_name']);
  $query->bindValue(":last_name", $_POST['last_name']);
  $query->bindValue(":email", $_POST['email']);
  $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $query->bindValue(":password", $hashedPassword);
  $query->execute();
  $userID = $db->lastinsertid();



// SUCCESS
$response = ["info"=>"user created", "userID" => $userID];
echo json_encode( $response );


// 
}catch(Exception $ex){
  http_response_code(500);
  echo 'System under maintainance';
  echo $ex;
  exit();
}




// function to manage responding in case of an error
function send_400($error_message){
    header('Content-Type: application/json');
    http_response_code(400);
    $response = ["info"=>$error_message];
    echo json_encode($response);
    exit();
  }
