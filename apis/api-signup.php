<?php
require_once(__DIR__ . '/../globals/globals.php');
// include(__DIR__.'/../private/keys.php');


// VALIDATE name
if (!isset($_POST['first_name'])) {
  send_400('first name is required');
}  //check if the name is passed
if (strlen($_POST['first_name']) < 2) {
  send_400('first name must have minimum 2 characters');
}   // check if the name contain at least 2 character
if (strlen($_POST['first_name']) > 30) {
  send_400('first name must have maximum 30 characters');
}   // check if the name contain at least 2 character

// VALIDATE last_name
if (!isset($_POST['last_name'])) {
  send_400('last name is required');
}  //check if the last_name is passed
if (strlen($_POST['last_name']) < 2) {
  send_400('last name must have minimum 2 characters');
}   // check if the last_name contain at least 2 character
if (strlen($_POST['last_name']) > 15) {
  send_400('last name must have maximum 15 characters');
}      // check if the last_name contain at least 2 character

// VALIDATE email
if (!isset($_POST['email'])) {
  send_400('email is required');
}
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
  send_400('email is invalid');
}

// VALIDATE password
if (!isset($_POST['password'])) {
  _res(400, ['info' => 'password required']);
};
if (strlen($_POST['password']) < _PASSW0RD_MIN_LEN) {
  _res(400, ['info' => 'password too short. Password length shoud be minimum ' . _PASSW0RD_MIN_LEN . ' charachetrs']);
};
if (strlen($_POST['password']) > _PASSW0RD_MAX_LEN) {
  _res(400, ['info' => 'password too long.  Password length shoud be maximum ' . _PASSW0RD_MAX_LEN . ' charachetrs']);
};

// VALIDATE phone_number
if (!isset($_POST['phone_number'])) {
  _res(400, ['info' => 'phone number required']);
};
if (strlen($_POST['phone_number']) < 8) {
  _res(400, ['info' => 'phone number too short. Phone number length shoud be minimum 8 digits']);
};
if (strlen($_POST['phone_number']) > 8) {
  _res(400, ['info' => 'phone number too long. Phone number length shoud be maximum 8 digits']);
};

// VALIDATE re-password
if (!isset($_POST['re-password'])) {
  _res(400, ['info' => 're-password required']);
};
if (($_POST['re-password'] !== $_POST['password'])) {
  _res(400, ['info' => 'passwords do not match']);
};

// Connect to DB
// $db = require_once(__DIR__.'/../globals/db.php');
$db = _db();



try {
  $verification_key = bin2hex(random_bytes(16));
  $pwd_reset_key = bin2hex(random_bytes(16));

  // Insert data in the DB
  $query = $db->prepare('INSERT INTO users VALUES(:user_id, :first_name, :last_name,:phone_number, :email, :password, :verified, :verification_key, :pwd_reset_key)');
  $query->bindValue(":user_id", null); // The db will give this automaticaly.
  $query->bindValue(":first_name", $_POST['first_name']);
  $query->bindValue(":last_name", $_POST['last_name']);
  $query->bindValue(":phone_number", $_POST['phone_number']);
  $query->bindValue(":email", $_POST['email']);
  $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $query->bindValue(":password", $hashedPassword);
  $query->bindValue(":verified", 0);
  $query->bindValue(":verification_key", "$verification_key");
  $query->bindValue(":pwd_reset_key", $pwd_reset_key);
  $query->execute();
  $userID = $db->lastinsertid();


  // SUCCESS
  $response = ["info" => "Account created. Please go to your email and verify it in order to log in.", "userID" => $userID];
  echo json_encode($response);
} catch (Exception $ex) {
  http_response_code(500);
  echo 'System under maintainance';
  echo $ex;
  exit();
}



//SMS sent upon registration
try {
  $ch = curl_init();
  $sms_message = 'Welcome to Dummyzon,' . ' ' . $_POST['first_name'] . '.' . ' Your account has been created.';
  $fields = array('to_phone' => $_POST['phone_number'], 'message' => $sms_message, 'api_key' => '1918b7b1-5dbb-4514-88bf-ad27e13a35d0');
  $postvars = '';
  foreach ($fields as $key => $value) {
    $postvars .= $key . "=" . $value . "&";
  }
  // echo $postvars;
  $url = "https://fatsms.com/send-sms";
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_POST, 1);                //0 for a get request
  curl_setopt($ch, CURLOPT_POSTFIELDS, $postvars);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
  curl_setopt($ch, CURLOPT_TIMEOUT, 20);
  $response = curl_exec($ch);
  // print "curl response is:" . $response;
  // echo "Message sent successfully";
  curl_close($ch);
} catch (Exception $ex) {
  echo $ex;
  echo "System under maintainance";
}



// Email verification
$_subject = "Account email verification";
$name = $_POST['first_name'];
$_to_email = $_POST['email'];
$_message = "Thanks for signing up. 
      <a href='http://localhost/validate-user.php?key=$verification_key&name=$name'> 
         Click here to verify your account. 
      </a>";

require_once(__DIR__ . "/../private/send_email.php");





// function to manage responding in case of an error
function send_400($error_message)
{
  header('Content-Type: application/json');
  http_response_code(400);
  $response = ["info" => $error_message];
  echo json_encode($response);
  exit();
}
