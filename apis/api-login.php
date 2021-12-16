<?php

require_once(__DIR__ . '/../globals/globals.php');


// Validate the email
if (!isset($_POST['email'])) {
  _res(400, ['info' => 'email is required']);
};
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
  _res(400, ['info' => 'typed email is invalid', 'error on line' => __LINE__]);
};


// Validate the password
if (!isset($_POST['password'])) {
  _res(400, ['info' => 'Password is required. Please type your password.']);
};
if (strlen($_POST['password']) < _PASSW0RD_REQUIRED) {
  _res(400, ['info' => 'Password is required. Please type your password.']);
};
if (strlen($_POST['password']) > _PASSW0RD_MAX_LEN) {
  _res(400, ['info' => 'Password too long. Password length shoud be Maximum ' . _PASSW0RD_MAX_LEN . ' charachetrs']);
};





$db = _db();


try {
  $query = $db->prepare('SELECT * FROM users WHERE email = :email ');
  $query->bindValue(':email', $_POST['email']);
  $query->execute();
  $row = $query->fetch();
  // echo json_encode($row);

  if (!$row) {
    _res(400, ['info' => 'wrong credentials', 'error line' => __LINE__]);
  }

  // Password hash verify
  if (!password_verify($_POST['password'], $row['password'])) {
    _res(400, ['info' => "Wrong password", 'error line' => __LINE__]);
  };

  // Check if the user's email is verified
  if ($row['verified'] != 1) {
    _res(400, ['info' => 'User email is not verified. Please check your email and click the verification link.']);
  };

  // Success
  session_start();
  $_SESSION['first_name'] = $row['first_name'];
  $_SESSION['last_name'] = $row['last_name'];
  $_SESSION['email'] = $row['email'];
  $_SESSION['phone_number'] = $row['phone_number'];
  $_SESSION['userId'] = $row['userId'];
  _res(200, ['info' => 'Login successful']);
} catch (Exception $ex) {
  _res(500, ['info' => 'system under maintainance', 'error' => __LINE__]);
}
  




  


  // Object { userId: "165", first_name: "aa", last_name: "aa", email: "andrei.dummy.mail@gmail.com", password: "$2y$10$mswVrn5D4DTH312C.NONAOwauScsJXYQrBtxfXEFUMy7BJ8FNBaeW", verified: "0", verification_key: "b907201cdbb3d8c465f8dc937c9b254f" }










// // connect to the db
// try{
// $db = _db();
// }catch(Exception $ex){
//     _res(500, ['info'=>'system under maintainance', 'error'=>__LINE__]);
// }

// try{
// $q = $db->prepare('SELECT * FROM users WHERE email = :email');
// $q->bindValue(':email', $_POST['email']);
// $q->execute();
// $row = $q->fetch();
// // var_dump($row); //see the data from the db
// // print_r($row);//see the data from the db
// // echo json_encode($row);//see the data from the db
// // var_export($row);//see the data from the db
// if(!$row){ _res[400, 'info'=>'wrong credential','error'=>__LINE__]};



// // Expected fake variables
// // $correct_email = 'a@a.com';
// // $correct_password = 'password';

// // if( $correct_email != $_POST['email'] || $correct_password != $_POST['password']){
// //     _res(400, ['info' =>'wrong credential']);
// // }


// //Success
// session_start();
// $_SESSION ['user_name'] = $row['user_name'];
// _res(200, ['info' => 'success login']); 

// }catch(Exception $ex){
//     _res(500, ['info'=>'system under maintainance', 'error'=>__LINE__]);
// }
