<?php
require_once(__DIR__ . '/../globals/globals.php');



// VALIDATE email
if (!isset($_POST['email'])) {
  send_400('email is required');
}
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
  send_400('email is invalid');
}

// VALIDATE password
if (!isset($_POST['password'])) {
  send_400('new password is required');
}
if (strlen($_POST['password']) < _PASSW0RD_MIN_LEN) {
  _res(400, ['info' => 'password too short. Password length shoud be minimum ' . _PASSW0RD_MIN_LEN . ' charachetrs']);
};
if (strlen($_POST['password']) > _PASSW0RD_MAX_LEN) {
  _res(400, ['info' => 'password too long.  Password length shoud be Maximum ' . _PASSW0RD_MAX_LEN . ' charachetrs']);
};

// VALIDATE re-password
if (!isset($_POST['re-password'])) {
  _res(400, ['info' => 're-password required']);
};
if (($_POST['re-password'] !== $_POST['password'])) {
  _res(400, ['info' => 'passwords do not match']);
};


// Connect to DB
$db = _db();


try {
  $db->beginTransaction();

  $query = $db->prepare('UPDATE users SET password = :password where email = :email');
  $query->bindValue(':email', $_POST['email']);
  $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $query->bindValue(':password', $hashedPassword);
  $query->execute();

  $query = $db->prepare('UPDATE users SET pwd_reset_key = :pwd_reset_key WHERE email = :email');
  $query->bindValue(':email', $_POST['email']);
  $pwd_reset_key = bin2hex(random_bytes(32));
  $query->bindValue('pwd_reset_key', $pwd_reset_key);
  $query->execute();

  $db->commit();

  $response = ["info" => "Yaaay! Password has been reset. You will be redirected to the Log-in page"];
  echo json_encode($response);
} catch (Exception $ex) {
  http_response_code(500);
  echo 'System under maintainance';
  $db->rollBack();
  echo $ex;
  exit();
}



try {

  // // Select the matching mail from the DB
  $query = $db->prepare(' SELECT * FROM users  WHERE email = :email');
  $query->bindValue(':email', $_POST['email']);
  $query->execute();
  $row = $query->fetch();
  // var_dump($row);
  // print_r($row);
  // echo json_encode($row['pwd_reset_key']);


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
