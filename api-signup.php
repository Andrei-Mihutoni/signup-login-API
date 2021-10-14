<?php



// VALIDATE name
if( ! isset( $_POST['name'] ) ){send_400('name is required');}  //check if the name is passed
if ( strlen( $_POST['name'] ) < 2  ) {send_400('name must have minimum 2 characters');}   // check if the name contain at least 2 character
if ( strlen( $_POST['name'] ) > 15  ) {send_400('name must have maximum 15 characters');}   // check if the name contain at least 2 character

// VALIDATE lastName
if( ! isset( $_POST['lastName'] ) ){send_400('lastName is required');}  //check if the lastName is passed
if ( strlen( $_POST['lastName'] ) < 2  ) {send_400('lastName must have minimum 2 characters');}   // check if the lastName contain at least 2 character
if ( strlen( $_POST['lastName'] ) > 15  ) {send_400('lastName must have 15 characters'); }      // check if the lastName contain at least 2 character

// VALIDATE email
if ( ! isset ( $_POST['email'] ) ) {send_400('email is required');}
if ( ! filter_var( $_POST['email'], FILTER_VALIDATE_EMAIL ) )  {send_400('email is invalid');}



// Connect to DB
$db = require_once('db.php');
try{
  // Insert data in the DB
  $query = $db->prepare('INSERT INTO users VALUES(:user_id, :user_name, :lastName, :email)');
  $query->bindValue(":user_id", null); // The db will give this automaticaly.
  $query->bindValue(":user_name", $_POST['name']);
  $query->bindValue(":lastName", $_POST['lastName']);
  $query->bindValue(":email", $_POST['email']);
  $query->execute();
  $userID = $db->lastinsertid();

  // SUCCESS
//   header('Content-Type: application/json');
//   echo '{"info":"user created", "userID":"'.$userID.'"}';
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
